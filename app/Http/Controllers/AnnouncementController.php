<?php

namespace App\Http\Controllers;

use App\Events\AnnouncementVisitEvent;
use App\Events\MakePayment;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Events\EventCheckSubscription;
use App\Http\Resources\AnnounceResource;
use App\Models\User;
use App\Models\Image;
use App\Repositories\AnnouncementRepository;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class AnnouncementController extends Controller
{
    private AnnouncementRepository $annoucementRepository;

    public function __construct(AnnouncementRepository $announcementRepository)
    {
        $this->announcementRepository = $announcementRepository;
    }

    public function index()
    {
        event(new EventCheckSubscription());
        return AnnounceResource::collection(Announcement::orderBy('subscribe_id','DESC')->where('status',1)->get());

    }

    public function nonVip()
    {
        event(new EventCheckSubscription());
        return AnnounceResource::collection(Announcement::orderBy('subscribe_id','DESC')->where('subscribe_id','!=',3)->where('status',1)->get());
       
    }

    public function populars()
    {
        event(new EventCheckSubscription());
        $collection = AnnounceResource::collection(Announcement::orderBy('subscribe_id','DESC')->where('status',1)->get());
        $sorted = $collection->sortBy([
                            ['visits', 'desc'],
                        ]);
        $ads = $sorted->take(10);
        return $ads->all();
    }

    public function recents()
    {
        event(new EventCheckSubscription());
        $collection = AnnounceResource::collection(Announcement::orderBy('created_at','DESC')->where('status',1)->get());

        $ads = $collection->take(10);
        return $ads->all();
    }

    public function getAdsByTown($townId)
    {
        return AnnounceResource::collection(Announcement::orderBy('subscribe_id','DESC')->where('status',1)->where('town_id', $townId)->get());
    }

    public function getAdsByQuarter($quarterId)
    {
        return AnnounceResource::collection(Announcement::orderBy('subscribe_id','DESC')->where('status',1)->where('quarter_id', $quarterId)->get());
    }

    public function getAdsByCategory($categoryId)
    {
        return AnnounceResource::collection(Announcement::where('announcement_category_id', $categoryId)->get());
    }

    public function AdsByUser($userId)
    {
        return AnnounceResource::collection(Announcement::where('user_id', $userId)->get());
    }

    public function store(Request $request): JsonResponse
    {
        $announcementDetails = $request->only([
            'client',
            'details'
        ]);

        return response()->json(
            [
                'data' => $this->announcementRepository->createAnnouncement($announcementDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    public function show(Announcement $announce)
    {
        //event(new AnnouncementVisitEvent($announce));
       return new AnnounceResource($announce);
    }

    public function getAnnounce($name,$slug){

        $user=User::where('username',$name)->first();

        $announce=AnnounceResource::collection(Announcement::where("user_id",$user->id)->where('slug',$slug)->get());
        $a=Announcement::where("user_id",$user->id)->where('slug',$slug)->first();
        $event=event(new AnnouncementVisitEvent($a));
        return $announce;
    }

     public function getSimilarAds($name,$slug){
        $user=User::where('username',$name)->first();

        $announce = (Announcement::where("user_id",$user->id)->where('slug',$slug)->get())[0];
        $announces = AnnounceResource::collection(Announcement::where("town_id",$announce->town_id)->get());
        return $announces;
    }

    public function update(Request $request): JsonResponse
    {
        $announcementId = $request->route('id');
        $announcementDetails = $request->only([
            'client',
            'details'
        ]);

        return response()->json([
            'data' => $this->announcementRepository->updateAnnouncement($announcementId, $announcementDetails)
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $announcementId = $request->route('id');
        $this->announcementRepository->deleteAnnouncement($announcementId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function getAnnouncesByTown(): JsonResponse
    {

        try{
               return response()->json($this->announcementRepository->getAnnouncementsByTown());
        }
        catch(e){
            return response("{error:Unable to fetch data}", 500)
                  ->header('Content-Type', 'application/json');
        }
    }

    public function displayAdsImage($id, $path)
    {
        $imageDisplay = Image::find($path);
        //return $imageDisplay;
        $image = ImageIntervention::make(storage_path('app/public/ads/'.$id.'/'. $imageDisplay->path));
        $i=ImageIntervention::make(storage_path("app/public/logo.png"));
        $i->resize(150, 150);
        $i->blur();

        $image->insert($i,'center',2,2);
        return $image->psrResponse($i);

    }

    /**
     * Delete ads's image
     */
    public function deleteAdsImage($id, $path)
    {
        $ad = Announcement::find($id);
        $image = Image::find($path);
        \Illuminate\Support\Facades\Storage::delete('public/ads/'.$id.'/'.$image->path);
        $ad->images()->detach($image->id);
        $image->delete();
        
        return response("Image deleted successfully", 200)
                  ->header('Content-Type', 'application/json');

    }

     /***
     * Display ads video
     */
    public function displayAdsVideo($id, $path)
    {
       return response()->download(storage_path('app\public\ads\\'.$id.'\\videos\\'. $path));

    }

    public function homepageAnnoncement(){
        return AnnounceResource::collection(Announcement::OrWhere('subscribe_id',2)->OrWhere('subscribe_id',3)->orderby('subscribe_id','DESC')->where('status',1)->limit(9)->inRandomOrder()->get());
    }

    public function vipAnnoncement(){
        return AnnounceResource::collection(Announcement::Where('subscribe_id',3)->where('status',1)->inRandomOrder()->get());
    }

    public function goldAnnoncement(){
        return AnnounceResource::collection(Announcement::Where('subscribe_id',2)->where('status',1)->inRandomOrder()->get());
    }
}

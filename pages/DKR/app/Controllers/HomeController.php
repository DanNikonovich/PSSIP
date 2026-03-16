<?php
require_once BASE_PATH . '/app/Core/Controller.php';
require_once BASE_PATH . '/app/Models/Event.php';
require_once BASE_PATH . '/app/Models/Promo.php';
require_once BASE_PATH . '/app/Models/Faq.php';
require_once BASE_PATH . '/app/Models/Comment.php';
require_once BASE_PATH . '/app/Models/BikeInfo.php';
require_once BASE_PATH . '/app/Models/BikeSlider.php';


class HomeController extends Controller
{
    public function index(): void
    {
        $events = Event::all();
        $faq = Faq::allActive();
        $comments = Comment::latestVisible(6);
        $bikeSpecs  = BikeInfo::getVisibleBySection('specs');
        $bikeLimits = BikeInfo::getVisibleBySection('limits');
        $bikeSlides = BikeSlider::allVisible();

        $this->view('index', [
            'events' => $events,
            'faq' => $faq,
            'comments' => $comments,
            'bikeSpecs' => $bikeSpecs,
            'bikeLimits' => $bikeLimits,
            'bikeSlides' => $bikeSlides
        ]);

    }

    public function rules(): void
    {
        $this->view('rules');
    }
}
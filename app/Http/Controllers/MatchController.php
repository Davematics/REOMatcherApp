<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchProfileResource;
use App\Services\MatchService;

class MatchController extends Controller
{
    protected $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    public function index($propertyId)
    {
        $searchProfiles = $this->matchService->getMatched($propertyId);

        return SearchProfileResource::collection($searchProfiles);
    }

}

<?php

namespace App\Services\AIModerator\Repositories;

interface OpenAiModeratorInterface 
{
 public function Examine_Text_Content(String $input);
}

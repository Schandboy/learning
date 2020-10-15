<?php

namespace App\Entities;

use App\Lesson;
use App\Series;
use Redis;
use function foo\func;

trait Learning
{


    public function completeLesson($lesson)
    {
        Redis::sadd("user:{$this->id}:series:{$lesson->series->id}", $lesson->id);
    }


    public function percentageCompletedForSeries($series)
    {
        $lessons_in_series = $series->lessons->count();
        $total_lessons_completed = $this->getlessonscompleted($series);
        return ($total_lessons_completed / $lessons_in_series) * 100;
    }

    public function getlessonscompleted($series)
    {
        return count($this->getCompletedLessonsForASeries($series));
    }

    public function getCompletedLessonsForASeries($series)
    {
        return Redis::smembers("user:{$this->id}:series:{$series->id}");
    }

    public function hasStartedSeries($series)
    {
        return $this->getlessonscompleted($series) > 0;
    }

    public function getCompletedLesson($series)
    {
        $completedLessons = $this->getCompletedLessonsForASeries($series);
        return collect($completedLessons)->map(function ($lessonId) {
            return Lesson::find($lessonId);
        });
    }

    public function hasCompletedLesson($lesson)
    {
        return in_array(
            $lesson->id,
            $this->getCompletedLessonsForASeries($lesson->series)
        );
    }

    public function seriesBeingWatchedId(){
        $keys = Redis::keys("user:{$this->id}:series:*");
        $seriesIds = [];
        foreach ($keys as $key):
            $seriesId = explode(':', $key)[3];
            array_push($seriesIds,$seriesId);
        endforeach;
        return $seriesIds;
    }

    public function seriesBeingWatched()
    {


        return collect($this->seriesBeingWatchedId())->map(function ($id){
            return Series::find($id);
        })->filter();
    }

    public function getTotalNoOfCompletedLessons(){
        $keys=Redis::keys("user:{$this->id}:series:*");
        $result=0;
        foreach ($keys as $key):
            $result+=count(Redis::smembers($key));
        endforeach;
        return $result;
    }

    public function getRouteKeyName(){
        return 'username';
    }

    public function getNextLessonToWatch($series){
        $lesson=$this->getCompletedLessonsForASeries($series);
        $lessonId=end($lesson);
        return Lesson::find($lessonId)->getNextLesson();
    }

}
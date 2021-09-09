<?php

namespace App\Http\Resources;

use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
        $user = Auth::user();
        $color = '#2196f3';
        //approved reservation
        if( $user->calendars()->where('calendars.id', $this->id)->where('status', 'approved')->exists()){
            $color = '#4caf4f';
        }
        //full capacity
        elseif( $this->approvedUsers->count() >= $this->capacity){
            $color = '#f44336';
        }
        //pending reservation
        elseif( $user->calendars()->where('calendars.id', $this->id)->where('status', 'pending')->exists()){
            $color = '#e91e62';
        }
        elseif($user->role->name == 'admin' && $this->pendingUsers->count() > 0){
            $color = 'purple';
        }

        return [
            'id' => $this->id,
            'title' => $this->title . ' ('.$this->users->count().'/'.$this->capacity.')',
            'start' => $this->start,
            'end' => $this->end,
            'timeStart' => $this->timeStart,
            'timeEnd' => $this->timeEnd,
            'capacity' => $this->capacity,
            'users' => $this->users,
            'color' => $color,
        ];
    }
}

<?php

namespace App\Http\Livewire\Students;

use App\Models\Event;
use Livewire\Component;

class CalendarStudent extends Component
{

    public $events = '';

 
    public function getevent()
    {       
        $events = Event::select('id','title','start')->get();
 
        return  json_encode($events);
    }

    
    public function render()
    {
        $events = Event::select('id','title','start')->get();
 
        $this->events = json_encode($events);
        return view('livewire.students.calendar-student');
    }
}

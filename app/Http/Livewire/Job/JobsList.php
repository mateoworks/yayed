<?php

namespace App\Http\Livewire\Job;

use App\Models\Job;
use Livewire\Component;
use Livewire\WithPagination;

class JobsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function destroyJob(Job $job)
    {
        $job->delete();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó la ocupación']);
    }
    public function render()
    {
        return view('livewire.job.jobs-list', [
            'jobs' => Job::latest()->paginate(),
        ]);
    }
}

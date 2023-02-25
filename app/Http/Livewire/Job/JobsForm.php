<?php

namespace App\Http\Livewire\Job;

use App\Models\Job;
use Livewire\Component;

class JobsForm extends Component
{
    public Job $job;
    public function mount(Job $job)
    {
        $this->job = $job;
    }
    public function save()
    {
        $this->validate();
        $this->job->save();
        $this->redirectRoute('job.index');
    }
    public function rules()
    {
        return [
            'job.name' => ['required', 'max:100']
        ];
    }
    public function render()
    {
        return view('livewire.job.jobs-form');
    }
}

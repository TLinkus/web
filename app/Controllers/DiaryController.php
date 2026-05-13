<?php

namespace App\Controllers;

use App\Models\ActionLogModel;
use App\Models\LessonEntryModel;
use App\Models\LessonModel;

class DiaryController extends BaseController
{
    public function edit($lessonId): string
    {
        return view('diary/form', [
            'title' => 'Dienyno pildymas',
            'lesson' => (new LessonModel())->find($lessonId),
            'entry' => (new LessonEntryModel())->where('lesson_id', $lessonId)->first(),
        ]);
    }

    public function update($lessonId)
    {
        $entryModel = new LessonEntryModel();
        $data = $this->request->getPost();
        $data['lesson_id'] = $lessonId;
        $data['filled_at'] = date('Y-m-d H:i:s');
        $existing = $entryModel->where('lesson_id', $lessonId)->first();

        $ok = $existing ? $entryModel->update($existing['id'], $data) : $entryModel->insert($data);
        if (! $ok) {
            return redirect()->back()->withInput()->with('errors', $entryModel->errors());
        }

        (new LessonModel())->update($lessonId, ['status' => 'completed']);
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'diary_update', 'Užpildytas dienynas pamokai #' . $lessonId);
        return redirect()->to('/lessons/' . $lessonId)->with('success', 'Dienynas išsaugotas.');
    }
}

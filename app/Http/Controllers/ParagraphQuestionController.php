<?php

namespace App\Http\Controllers;

use App\Models\ParagraphQuestion;

class ParagraphQuestionController extends Controller
{
    public function destroy($id)
    {
        try {
            $paragraphQuestion = ParagraphQuestion::findOrFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'No paragraph question found.',
            ]);
        }

        $result = $paragraphQuestion->delete();

        if ($result) {
            return response()->json([
                'status' => true,
                'message' => 'Paragraph question deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Paragraph question was not deleted, Try again.',
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;

class ParagraphController extends Controller
{
    public function destroy($id)
    {
        try {
            $paragraph = Paragraph::findOrFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'No paragraph found.',
            ]);
        }

        $result = $paragraph->delete();

        if ($result) {
            return response()->json([
                'status' => true,
                'message' => 'Paragraph deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Paragraph was not deleted, Try again.',
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BookSection;

class BookSectionController extends Controller
{
    public function destroy($id)
    {
        try {
            $bookSection = BookSection::findOrFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'No book section found.',
            ]);
        }

        $result = $bookSection->delete();

        if ($result) {
            return response()->json([
                'status' => true,
                'message' => 'Book section deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Book section was not deleted, Try again.',
            ]);
        }
    }
}

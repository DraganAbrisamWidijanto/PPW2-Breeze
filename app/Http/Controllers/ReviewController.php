<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $bukuId)
{
    $this->validate($request, [
        'review' => 'required',
    ]);

    $review = new Review();
    $review->buku_id = $bukuId;
    $review->user_id = Auth::id();
    $review->content = $request->input('review');
    
    // Implementasi profanity filter (asumsi: ada ProfanityFilter class)
    $profanityFilter = new ProfanityFilter();
    if ($profanityFilter->containsProfanity($review->content)) {
        // Kata-kata tidak sopan terdeteksi
        $review->is_moderated = true;
        $review->save();

        // Notifikasi admin (asumsi: ada AdminNotification class)
        AdminNotification::notifyProfanity($review);

        return redirect()->back()->with('warning', 'Review mengandung kata-kata tidak sopan dan sedang dalam moderasi.');
    }

    // Kata-kata sopan, review langsung ditampilkan
    $review->is_moderated = false;
    $review->save();

    return redirect()->back()->with('success', 'Review berhasil ditambahkan.');
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrashCategory;
use App\Models\TrashCategoryPhoto;
use Validator;
use Illuminate\Support\Facades\File;

class TrashCategoryController extends Controller
{
    public function index()
    {
        $session = session('partner_id');
        $category = TrashCategory::where('partner_id', $session)->with('photos')->get();

        $data = [
            'category' => $category
        ];
        return view('partner.trash.category.manage', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'category_name' => 'required|max:255',
            'description' => 'required',
            'partner_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = new TrashCategory();
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->partner_id = $request->partner_id;
        $category->save();

        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                $imageName = uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('partner/trash/category/'), $imageName);

                $trashCategory = new TrashCategoryPhoto;
                $trashCategory->trash_category_id = $category->id;
                $trashCategory->image = $imageName;
                $trashCategory->save();
            }
        }
        return redirect()->back()->with('success', 'Trash category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'category_name' => 'required|max:255',
            'description' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = TrashCategory::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->partner_id = $request->partner_id;
        $category->save();

        if ($request->hasFile('image')) {
            // Delete old photos associated with the TrashCategory
            $oldImages = public_path('partner/trash/category/');

            if ($category->photos) {
                foreach ($category->photos as $photo) {
                    $oldImage = $oldImages . $photo->image;
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }
            }

            $images = $request->file('image');
            foreach ($images as $image) {
                $imageName = uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('partner/trash/category/'), $imageName);

                $trashCategory = new TrashCategoryPhoto;
                $trashCategory->trash_category_id = $category->id;
                $trashCategory->image = $imageName;
                $trashCategory->save();
            }
        }

        return redirect()->back()->with('success', 'Trash category updated successfully.');
    }

    public function delete($id)
{
    $category = TrashCategory::findOrFail($id);

    // Delete category photos from public path
    $oldImages = public_path('partner/trash/category/');
    if ($category->photos) {
        foreach ($category->photos as $photo) {
            $oldImage = $oldImages . $photo->image;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }
    }

    // Delete category and related photos from database
    $category->photos()->delete();
    $category->delete();

    return redirect()->back()->with('success', 'Trash category deleted successfully.');
}



}

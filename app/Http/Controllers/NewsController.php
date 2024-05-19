<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsPhoto;
use Validator;

class NewsController extends Controller
{
    public function index()
    {
        $session = session('partner_id');
        $news = News::where('partner_id', $session)->with('category')->get();
        $category = NewsCategory::get();

        $data = [
            'news' => $news,
            'category' => $category
        ];
        return view('admin.news.manage', $data);
    }
    public function list()
    {
        $news = News::with([
            'partner',
            'category'
        ])->get();
        $category = NewsCategory::get();

        $data = [
            'news' => $news,
            'category' => $category
        ];
        return view('admin.news.list', $data);
    }
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'partner_id' => 'required',
            'category_id' => 'required',
            'description' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $news = new News();
        $news->partner_id = $request->partner_id;
        $news->title = $request->title;
        $news->date_news = date('Y-m-d');
        $news->description = $request->description;
        $news->status = '1';
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('partner/news/thumbnail'), $imageName);
            $news->thumbnail = $imageName;
        }
        $news->category_id = $request->category_id;
        $news->save();

        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                $imageName = uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('partner/news'), $imageName);

                $newsImage = new NewsPhoto;
                $newsImage->news_id = $news->id;
                $newsImage->image = $imageName;
                $newsImage->save();
            }
        }

        return redirect()->back()->with('success', 'News created successfully.');
    }

    public function details($id)
    {
        $category = NewsCategory::get();
        $news = News::with([
            'photos',
            'category'
        ])->findOrFail($id);
        $data = [
            'news' => $news,
            'category' => $category
        ];
        return view('admin.news.details', $data);
    }
    public function admin_detail($id)
    {
        $category = NewsCategory::get();
        $news = News::with([
            'photos',
            'category'
        ])->findOrFail($id);
        $data = [
            'news' => $news,
            'category' => $category
        ];
        return view('admin.news.admin-details', $data);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:0,1',
            'news_category' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $news = News::findOrFail($id);
        $news->title = $request->title;
        $news->category_id = $request->news_category;
        $news->description = $request->description;
        $news->status = $request->status;
        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail != null) {
                  $oldImage = public_path('partner/news/thumbnail/' . $news->thumbnail);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $image = $request->file('thumbnail');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('partner/news/thumbnail'), $imageName);
            $news->thumbnail = $imageName;
        }
        $news->save();

        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                $imageName = uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('partner/news'), $imageName);

                $newsImage = new NewsPhoto;
                $newsImage->news_id = $news->id;
                $newsImage->image = $imageName;
                $newsImage->save();
            }
        }

        return redirect()->back()->with('success', 'News updated successfully.');
    }


    public function delete($id)
    {
        $news = News::findOrFail($id);
        $newsPhotos = NewsPhoto::where('news_id', $news->id)->get();

        foreach ($newsPhotos as $newsPhoto) {
            $imagePath = public_path('partner/news') . '/' . $newsPhoto->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $newsPhoto->delete();
        }

        $news->delete();

        return redirect()->back()->with('success', 'News deleted successfully.');
    }

    public function delete_image($id)
    {
        $photo = NewsPhoto::findOrFail($id);
        $imagePath = public_path('partner/news') . '/' . $photo->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $photo->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }



}

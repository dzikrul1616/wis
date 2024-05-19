<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsCategory;
use Validator;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $category = NewsCategory::get();

        $data = [
            'category' => $category
        ];
        return view('admin.news-category.manage', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'news_category' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = new NewsCategory();
        $category->news_category = $request->news_category;
        $category->save();
        return redirect()->back()->with('success', 'News category data successfully added');
    }

    public function update($id, Request $request)
    {
        $rules = [
            'news_category' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = NewsCategory::findOrFail($id);
        $category->news_category = $request->news_category;
        $category->save();
        return redirect()->back()->with('success', 'News category data successfully updated');
    }

    public function delete($id)
    {
        $category = NewsCategory::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'News category data successfully deleted');
    }
}

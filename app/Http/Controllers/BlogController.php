<?php

namespace App\Http\Controllers;

use App\Models\AccountIncome;
use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\BlogTagRelation;
use App\Models\Branch;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller {
    public function index() {
        return view('admin.blogs.blogs', [
            'blogs' => Blog::orderBy('created_at', 'desc')->get(),
            'tags' => BlogTag::all(),
        ]);
    }

    public function blog_add(Request $request) {

        if ($request->blog_banner_image != '') {
            $validator = Validator::make($request->all(), [
                'blog_category' => 'required',
                'blog_title' => 'required',
                'blog_banner_image' => 'mimes:jpg,jpeg,png,gif,webp|max:1024',
                'blog_post' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $blog = Blog::create([
                    'blog_category' => $request->blog_category,
                    'blog_title' => $request->blog_title,
                    'blog_post' => $request->blog_post,
                    'meta_description' => $request->meta_description,
                ]);

                $tags = $request->blog_tags;
                if (!empty($tags)) {
                    foreach ($tags as $key => $tag) {
                        $blog_tag_relation =  BlogTagRelation::create([
                            'blog_id' => $blog->id,
                            'tag_id' => $tag,
                        ]);
                    }
                }

                $uploaded_image = $request->blog_banner_image;
                $ext = $uploaded_image->getClientOriginalExtension();
                $photo_name = 'blog-' . $blog->id . '.' . $ext;

                Image::make($uploaded_image)->save(public_path('assets/frontend/img/blog/' . $photo_name));
                Blog::find($blog->id)->update([
                    'blog_banner_image' => $photo_name
                ]);
                session()->flash('blogAddSuccess', 'New Blog Added successfully!');
                return response()->json(['success' => true]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'blog_category' => 'required',
                'blog_title' => 'required',
                'blog_post' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $blog = Blog::create([
                    'blog_category' => $request->blog_category,
                    'blog_title' => $request->blog_title,
                    'blog_post' => $request->blog_post,
                    'meta_description' => $request->meta_description,
                ]);

                $tags = $request->blog_tags;
                if (!empty($tags)) {
                    foreach ($tags as $key => $tag) {
                        $blog_tag_relation =  BlogTagRelation::create([
                            'blog_id' => $blog->id,
                            'tag_id' => $tag,
                        ]);
                    }
                }

                session()->flash('blogAddSuccess', 'New Blog Added successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function blog_view_modal($id) {
        return view('admin.madals.blog_view', [
            'blog' => Blog::find($id),
        ]);
    }

    public function blog_edit_modal($id) {
        $blog_tag_rel = BlogTagRelation::where('blog_id', $id)->get(['tag_id']);
        $array = json_decode($blog_tag_rel, true);
        $tagIds = array_column($array, 'tag_id');

        return view('admin.madals.edit-blog', [
            'blog' => Blog::find($id),
            'tags' => BlogTag::all(),
            'tagIds' => $tagIds,
        ]);
    }

    public function blog_update(Request $request) {
        $id = $request->id;
        $blog = Blog::find($id);

        if ($request->blog_banner_image != '') {
            $validator = Validator::make($request->all(), [
                'blog_category' => 'required',
                'blog_title' => 'required',
                'blog_banner_image' => 'mimes:jpg,jpeg,png,gif,webp|max:1024',
                'blog_post' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $blog->update([
                    'blog_category' => $request->blog_category,
                    'blog_title' => $request->blog_title,
                    'blog_post' => $request->blog_post,
                    'meta_description' => $request->meta_description,
                ]);

                if (BlogTagRelation::where('blog_id', $id)->exists()) {
                    BlogTagRelation::where('blog_id', $id)->delete();
                }

                $tags = $request->blog_tags;
                if (!empty($tags)) {
                    foreach ($tags as $key => $tag) {
                        $blog_tag_relation =  BlogTagRelation::create([
                            'blog_id' => $blog->id,
                            'tag_id' => $tag,
                        ]);
                    }
                }

                if ($blog->blog_banner_image != null) {
                    $old_image = public_path('assets/frontend/img/blog/' . $blog->blog_banner_image);
                    unlink($old_image);
                }

                $uploaded_image = $request->blog_banner_image;
                $ext = $uploaded_image->getClientOriginalExtension();
                $photo_name = 'blog-' . $blog->id . '.' . $ext;

                Image::make($uploaded_image)->save(public_path('assets/frontend/img/blog/' . $photo_name));
                $blog->update([
                    'blog_banner_image' => $photo_name
                ]);
                session()->flash('blogUpdateSuccess', 'Blog Updated successfully!');
                return response()->json(['success' => true]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'blog_category' => 'required',
                'blog_title' => 'required',
                'blog_post' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $blog->update([
                    'blog_category' => $request->blog_category,
                    'blog_title' => $request->blog_title,
                    'blog_post' => $request->blog_post,
                    'meta_description' => $request->meta_description,
                ]);

                if (BlogTagRelation::where('blog_id', $id)->exists()) {
                    BlogTagRelation::where('blog_id', $id)->delete();
                }

                $tags = $request->blog_tags;
                if (!empty($tags)) {
                    foreach ($tags as $key => $tag) {
                        $blog_tag_relation =  BlogTagRelation::create([
                            'blog_id' => $blog->id,
                            'tag_id' => $tag,
                        ]);
                    }
                }

                session()->flash('blogUpdateSuccess', 'Blog Updated successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function blog_delete($id) {
        $blog = Blog::find($id);

        if ($blog->blog_banner_image != null) {
            $old_image = public_path('assets/frontend/img/blog/' . $blog->blog_banner_image);
            unlink($old_image);
        }

        if ($blog->delete()) {
            return back()->with('dltSuccess', 'Blog deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function blog_tags() {

        return view('admin.blogs.tags.tags', [
            'tags' => BlogTag::all(),
        ]);
    }

    public function tag_add(Request $request) {
        $validator = Validator::make($request->all(), [
            'tag_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            BlogTag::create([
                'tag_name' => $request->tag_name,
            ]);

            session()->flash('tagAddSuccess', 'New Tag Added successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function tag_edit_modal($id) {
        return view('admin.madals.edit-tag', [
            'tag' => BlogTag::find($id),
        ]);
    }

    public function tag_update(Request $request) {
        $id = $request->id;
        $tag = BlogTag::find($id);

        $validator = Validator::make($request->all(), [
            'tag_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $tag->update([
                'tag_name' => $request->tag_name,
            ]);

            session()->flash('tagUpdateSuccess', 'Tag Updated successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function tag_delete($id) {
        $tag = BlogTag::find($id);

        if ($tag->delete()) {
            return back()->with('dltSuccess', 'Tag Deleted Successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }
}

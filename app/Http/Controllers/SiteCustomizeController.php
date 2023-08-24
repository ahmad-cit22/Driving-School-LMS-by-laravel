<?php

namespace App\Http\Controllers;

use App\Models\AboutPart;
use App\Models\BannerPart;
use App\Models\BranchPart;
use App\Models\CertifiedByPart;
use App\Models\ContactPart;
use App\Models\CounterFact;
use App\Models\CourseCategory;
use App\Models\DirectorSpeechPart;
use App\Models\FaqImage;
use App\Models\FaqQuestion;
use App\Models\Feature;
use App\Models\FeaturePart;
use App\Models\GalleryImage;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\TermsAndCondition;
use App\Models\TrainingProcessVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SiteCustomizeController extends Controller {
    public function customize_home() {
        return view('admin.customization.home', [
            'banner_part' => BannerPart::all()->first(),
            'feature_part' => FeaturePart::all()->first(),
            'features' => Feature::orderBy('priority')->get(),
            'counters' => CounterFact::orderBy('priority')->get(),
            'video' => TrainingProcessVideo::all()->first(),
            'faq_questions' => FaqQuestion::all(),
            'faq_image' => FaqImage::all()->first(),
            'gallery_images' => GalleryImage::all(),
        ]);
    }

    //banner part
    public function customize_home_banner(Request $request) {
        $banner_content = BannerPart::all()->first();

        $request->validate(
            [
                'subtitle' => 'required',
                'title' => 'required',
                'bottom_text' => 'required',
                'button_one_name' => 'required',
                'button_two_name' => 'required',
            ]
        );

        $banner_content->update([
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'bottom_text' => $request->bottom_text,
            'button_one_name' => $request->button_one_name,
            'button_two_name' => $request->button_two_name,
            'button_one_link' => $request->button_one_link,
            'button_two_link' => $request->button_two_link,
        ]);

        if ($request->banner_image != '') {

            $request->validate(
                [
                    'banner_image' => ['mimes:jpg,jpeg,png,gif,webp', 'max:2024'],
                ]
            );

            $uploaded_image = $request->banner_image;
            $ext = $uploaded_image->getClientOriginalExtension();
            $img_name = 'banner-' . Auth::id() . '.' . $ext;

            Image::make($uploaded_image)->resize(1400, 620)->save(public_path('assets/frontend/img/banners/' . $img_name));
            $banner_content->update([
                'banner_img' => $img_name,
            ]);
        }

        if ($request->logo_image != '') {

            $request->validate(
                [
                    'logo_image' => ['mimes:jpg,jpeg,png,gif,webp', 'max:2024'],
                ]
            );

            $uploaded_image = $request->logo_image;
            $ext = $uploaded_image->getClientOriginalExtension();
            $img_name = 'logo-' . Auth::id() . '.' . $ext;

            Image::make($uploaded_image)->resize(115, 45)->save(public_path('assets/frontend/img/logo/' . $img_name));
            $banner_content->update([
                'logo_image' => $img_name,
            ]);
        }

        return back()->with('success', 'Banner Edited Successfully!');
    }

    //feature part
    public function add_new_feature(Request $request) {

        $request->validate(
            [
                'title' => 'required',
                'text' => 'required',
                'icon' => 'required',
                'priority' => 'required',
            ]
        );

        Feature::insert([
            'title' => $request->title,
            'text' => $request->text,
            'icon' => $request->icon,
            'priority' => $request->priority,
            'created_at' => Carbon::now()
        ]);

        return back()->with('success', 'New Feature Added Successfully!');
    }

    public function customize_home_feature(Request $request) {
        $feature_content = FeaturePart::all()->first();
        $request->validate(
            [
                'title' => 'required',
                'subtitle' => 'required',
            ]
        );

        $feature_content->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
        ]);

        return back()->with('updateSuccess', 'Feature Part Updated Successfully!');
    }

    public function feature_edit_modal($id) {
        return view('admin.madals.edit-feature', [
            'feature' => Feature::find($id),
        ]);
    }

    public function feature_update(Request $request) {

        $feature = Feature::find($request->id);

        $request->validate(
            [
                'title' => 'required',
                'text' => 'required',
                'icon' => 'required',
                'priority' => 'required',
            ]
        );

        $feature->update([
            'title' => $request->title ?? $feature->title,
            'text' => $request->text ?? $feature->text,
            'icon' => $request->icon ?? $feature->icon,
            'priority' => $request->priority ?? $feature->priority,
        ]);


        session()->flash('success', 'Feature Edited Successfully!');
    }

    public function feature_delete($id) {
        if (Feature::find($id)->delete()) {
            return back()->with('success', 'Feature deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    //counter part
    public function add_new_counter(Request $request) {

        $request->validate(
            [
                'amountCounter' => 'required',
                'textCounter' => 'required',
                'iconCounter' => 'required',
                'priorityCounter' => 'required',
            ]
        );

        CounterFact::insert([
            'amount' => $request->amountCounter,
            'text' => $request->textCounter,
            'icon' => $request->iconCounter,
            'priority' => $request->priorityCounter,
            'created_at' => Carbon::now()
        ]);

        return back()->with('success', 'New Counter Added Successfully!');
    }

    public function counter_edit_modal($id) {
        return view('admin.madals.edit-counter', [
            'counter' => CounterFact::find($id),
        ]);
    }

    public function counter_update(Request $request) {

        $counter = CounterFact::find($request->id);

        $request->validate(
            [
                'amount' => 'required',
                'text' => 'required',
                'icon' => 'required',
                'priority' => 'required',
            ]
        );

        $counter->update([
            'amount' => $request->amount ?? $counter->amount,
            'text' => $request->text ?? $counter->text,
            'icon' => $request->icon ?? $counter->icon,
            'priority' => $request->priority ?? $counter->priority,
        ]);

        session()->flash('success', 'Counter Edited Successfully!');
    }

    public function counter_delete($id) {
        if (CounterFact::find($id)->delete()) {
            return back()->with('success', 'Counter deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }


    //training_video part
    public function add_training_video(Request $request) {

        $request->validate(
            [
                'titleVideo' => 'required',
                'videoLink' => 'required',
            ]
        );

        TrainingProcessVideo::all()->first()->update([
            'title' => $request->titleVideo,
            'link' => $request->videoLink,
            'created_at' => Carbon::now()
        ]);

        return back()->with('success', 'Video Updated Successfully!');
    }

    public function training_video_delete($id) {
        if (TrainingProcessVideo::find($id)->delete()) {
            return back()->with('success', 'Video deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }


    public function customize_contact_page() {
        return view('admin.customization.contact', [
            'branch_part' => BranchPart::all()->first(),
            'contact_part' => ContactPart::all()->first(),
        ]);
    }

    public function customize_branch_part(Request $request) {
        $branch_content = BranchPart::all()->first();
        $request->validate(
            [
                'title' => 'required',
                'subtitle' => 'required',
            ]
        );

        $branch_content->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
        ]);

        return back()->with('updateSuccess', 'Branch Part Updated Successfully!');
    }

    public function customize_contact_part(Request $request) {
        $contact_content = ContactPart::all()->first();
        $request->validate(
            [
                'title' => 'required',
                'subtitle' => 'required',
            ]
        );

        $contact_content->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
        ]);

        return back()->with('updateSuccess', 'Contact Part Updated Successfully!');
    }

    public function customize_about_page() {
        return view('admin.customization.about', [
            'about_part' => AboutPart::all()->first(),
            'director_speech_part' => DirectorSpeechPart::all()->first(),
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function customize_about_part(Request $request) {
        $about_content = AboutPart::all()->first();
        $request->validate(
            [
                'about_video_link' => 'required',
                'about_text' => 'required',
            ]
        );

        $about_content->update([
            'about_video_link' => $request->about_video_link,
            'about_text' => $request->about_text,
        ]);

        return back()->with('updateSuccess', 'About Part Updated Successfully!');
    }

    public function customize_director_speech_part(Request $request) {
        $director_speech_content = DirectorSpeechPart::all()->first();
        $request->validate(
            [
                'director_image' => 'max:1024|mimes:png,jpg,jpeg,webp,gif',
                'director_name' => 'required',
                'director_speech' => 'required',
            ]
        );
        $file_name = $director_speech_content->director_image;

        if (!empty($request->director_image)) {
            $uploaded_image = $request->director_image;
            $ext = $uploaded_image->getClientOriginalExtension();
            $file_name = 'director.' . $ext;

            Image::make($uploaded_image)->resize(340, 340)->save(public_path('assets/frontend/img/about/' . $file_name));
        }

        $director_speech_content->update([
            'director_image' => $file_name,
            'director_name' => $request->director_name,
            'director_speech' => $request->director_speech,
        ]);

        return back()->with('updateSuccess', 'Directors Speech Part Updated Successfully!');
    }

    public function customize_certified_by_add(Request $request) {

        $request->validate([
            'certified_by' => 'required|unique:course_categories,category_name',
            'certificate_image' => 'required|mimes:png,jpg,jpeg,webp,gif|max:2024',
        ], [
            'certified_by.required' => 'Please enter the certifier institution name.'
        ]);

        $certificate_id = CertifiedByPart::insertGetId([
            'certified_by' => $request->certified_by,
            'created_at' => Carbon::now(),
        ]);

        $uploaded_image = $request->certificate_image;
        $ext = $uploaded_image->getClientOriginalExtension();
        $photo_name = 'certificate-' . $certificate_id . '.' . $ext;

        Image::make($uploaded_image)->save(public_path('assets/frontend/img/footer/' . $photo_name));
        CertifiedByPart::find($certificate_id)->update([
            'certificate_image' => $photo_name
        ]);

        return back()->with('success', 'New certificate added successfully');
    }

    public function customize_certified_by_edit($id) {
        return view('admin.madals.edit-certified-by', [
            'certified_by_part' => CertifiedByPart::find($id)
        ]);
    }

    public function customize_certified_by_update(Request $request) {

        if ($request->certificate_image != '') {
            $validator = Validator::make($request->all(), [
                'certified_by' => 'required',
                'certificate_image' => 'mimes:png,jpg,jpeg,webp,gif|max:2024',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $certified_by = CertifiedByPart::find($request->id);

                $uploaded_image = $request->certificate_image;
                $ext = $uploaded_image->getClientOriginalExtension();
                $photo_name = 'certificate-' . $request->id . '.' . $ext;

                if ($certified_by->certificate_image != 'def-image.png') {
                    $old_image = public_path('assets/frontend/img/footer/' . $certified_by->certificate_image);
                    unlink($old_image);
                }

                Image::make($uploaded_image)->save(public_path('assets/frontend/img/footer/' . $photo_name));

                $certified_by->update([
                    'certified_by' => $request->certified_by ?? $certified_by->certified_by,
                    'certificate_image' => $photo_name
                ]);

                session()->flash('success', 'Certificate updated successfully!');
                return response()->json(['success' => true]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'certified_by' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $certified_by = CertifiedByPart::find($request->id);

                $certified_by->update([
                    'certified_by' => $request->certified_by ?? $certified_by->certified_by,
                ]);

                session()->flash('success', 'Certificate updated successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function customize_certified_by_delete($id) {
        $certified_by = CertifiedByPart::find($id);
        if ($certified_by->certificate_image != 'def-image.png') {
            $old_image = public_path('assets/frontend/img/footer/' . $certified_by->certificate_image);
            unlink($old_image);
        }

        if ($certified_by->delete()) {
            return back()->with('success', 'Course category deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function customize_gallery_image_add(Request $request) {

        $request->validate([
            'image_class' => 'required',
            'gallery_image' => 'required',
        ]);

        $gallery_image = GalleryImage::create([
            'image_class' => $request->image_class,
        ]);

        $uploaded_image = $request->gallery_image;
        $ext = $uploaded_image->getClientOriginalExtension();
        $file_name = 'gallery-' . $gallery_image->id . '.' . $ext;

        Image::make($uploaded_image)->save(public_path('assets/frontend/img/gallery/' . $file_name));

        $gallery_image->update([
            'image' => $file_name,
        ]);

        return back()->with('success', 'New Image added successfully');
    }

    public function customize_gallery_image_edit($id) {
        return view('admin.madals.edit-gallery-image', [
            'gallery_image' => GalleryImage::find($id),
        ]);
    }

    public function customize_gallery_image_update(Request $request) {

        if ($request->gallery_image != '') {
            $validator = Validator::make($request->all(), [
                'image_class' => 'required',
                'gallery_image' => 'mimes:png,jpg,jpeg,webp,gif|max:2024',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $gallery_image = GalleryImage::find($request->id);

                if ($gallery_image->image != 'def-image-1.jpg' && $gallery_image->image != 'def-image-2.jpg' && $gallery_image->image != 'def-image-3.jpg' && $gallery_image->image != 'def-image-4.jpg' && $gallery_image->image != 'def-image-5.jpg' && $gallery_image->image != 'def-image-6.jpg') {
                    $old_image = public_path('assets/frontend/img/gallery/' . $gallery_image->image);
                    unlink($old_image);
                }

                $uploaded_image = $request->gallery_image;
                $ext = $uploaded_image->getClientOriginalExtension();
                $photo_name = 'gallery-' . $request->id . '.' . $ext;

                Image::make($uploaded_image)->save(public_path('assets/frontend/img/gallery/' . $photo_name));

                $gallery_image->update([
                    'image_class' => $request->image_class ?? $gallery_image->image_class,
                    'image' => $photo_name
                ]);

                session()->flash('success', 'Gallery image updated successfully!');
                return response()->json(['success' => true]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'image_class' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $gallery_image = GalleryImage::find($request->id);

                $gallery_image->update([
                    'image_class' => $request->image_class ?? $gallery_image->image_class,

                ]);

                session()->flash('success', 'Gallery image updated successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function customize_gallery_image_delete($id) {
        $gallery_image = GalleryImage::find($id);

        if ($gallery_image->image != 'def-image-1.jpg' && $gallery_image->image != 'def-image-2.jpg' && $gallery_image->image != 'def-image-3.jpg' && $gallery_image->image != 'def-image-4.jpg' && $gallery_image->image != 'def-image-5.jpg' && $gallery_image->image != 'def-image-6.jpg') {
            $old_image = public_path('assets/frontend/img/gallery/' . $gallery_image->image);
            unlink($old_image);
        }

        if ($gallery_image->delete()) {
            return back()->with('success', 'Gallery image deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }



    public function customize_faq_add(Request $request) {

        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        FaqQuestion::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return back()->with('success', 'New question added successfully');
    }

    public function customize_faq_edit($id) {
        return view('admin.madals.edit-faq-question', [
            'question' => FaqQuestion::find($id)
        ]);
    }

    public function customize_faq_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $faq_question = FaqQuestion::find($request->id);

            $faq_question->update([
                'question' => $request->question ?? $faq_question->question,
                'answer' => $request->answer ?? $faq_question->answer,
            ]);

            session()->flash('success', 'Question updated successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function customize_faq_delete($id) {
        $question = FaqQuestion::find($id);

        if ($question->delete()) {
            return back()->with('success', 'Question deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function customize_faq_image_add(Request $request) {
        $faq_image = FaqImage::all()->first();
        $request->validate(
            [
                'faq_image' => 'required|mimes:png,jpg,jpeg,webp,gif|max:2024',
            ]
        );

        $old_file_name = $faq_image->image;

        if ($old_file_name != 'def-image.jpg' && $request->faq_image->getClientOriginalName() != $old_file_name) {
            $old_image = public_path('assets/frontend/img/faq/' . $old_file_name);
            unlink($old_image);
        }

        $uploaded_image = $request->faq_image;
        $ext = $uploaded_image->getClientOriginalExtension();
        $file_name = 'faq-image.' . $ext;

        Image::make($uploaded_image)->resize(560, 285)->save(public_path('assets/frontend/img/faq/' . $file_name));

        $faq_image->update([
            'image' => $file_name,
        ]);

        return back()->with('updateSuccess', 'FAQ Image Updated Successfully!');
    }

    // privacy policy
    public function customize_privacy_policy_page() {
        return view('admin.customization.privacy_policy', [
            'privacy_policy' => PrivacyPolicy::all()->first(),
        ]);
    }

    public function customize_privacy_policy_update(Request $request) {
        $privacy_policy = PrivacyPolicy::all()->first();

        $request->validate(
            [
                'privacy_policy' => 'required',
            ]
        );

        $privacy_policy->update([
            'privacy_policy' => $request->privacy_policy,
        ]);

        return back()->with('updateSuccess', 'Privacy Policy Updated Successfully!');
    }

    // terms_and_conditions
    public function customize_terms_and_conditions_page() {
        return view('admin.customization.terms_and_conditions', [
            'terms_and_conditions' => TermsAndCondition::all()->first(),
        ]);
    }

    public function customize_terms_and_conditions_update(Request $request) {
        $terms_and_conditions = TermsAndCondition::all()->first();

        $request->validate(
            [
                'terms_and_conditions' => 'required',
            ]
        );

        $terms_and_conditions->update([
            'terms_and_conditions' => $request->terms_and_conditions,
        ]);

        return back()->with('updateSuccess', 'Terms & Conditions Updated Successfully!');
    }

    // refund policy
    public function customize_refund_policy_page() {
        return view('admin.customization.refund_policy', [
            'refund_policy' => RefundPolicy::all()->first(),
        ]);
    }

    public function customize_refund_policy_update(Request $request) {
        $refund_policy = RefundPolicy::all()->first();

        $request->validate(
            [
                'refund_policy' => 'required',
            ]
        );

        $refund_policy->update([
            'refund_policy' => $request->refund_policy,
        ]);

        return back()->with('updateSuccess', 'Refund Policy Updated Successfully!');
    }
}

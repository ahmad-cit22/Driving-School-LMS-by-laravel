<?php

namespace Database\Seeders;

use App\Models\AboutPart;
use App\Models\BannerPart;
use App\Models\Blog;
use App\Models\BranchPart;
use App\Models\CertifiedByPart;
use App\Models\ContactPart;
use App\Models\CounterFact;
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
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontendSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // BannerPart 
        BannerPart::create([
            'subtitle' => 'Be Ready to get Pro',
            'title' => 'Learn to Drive with Confidence',
            'bottom_text' => 'Jpsum dolor sit amet, consectetur adipiscing elit, minim veniamsed sed do eiusmod tempor maksu eiusmod tempor maksu eiu',
            'button_one_name' => 'Check Courses',
            'button_two_name' => 'Learn More',
            'button_one_link' => '#',
            'button_two_link' => '#',
            'banner_img' => 'banner-1.jpg',
            'logo_image' => 'logo-1.png',
        ]);

        // FeaturePart
        FeaturePart::create([
            'title' => 'Our Features',
            'subtitle' => 'Lorem ipsum dolor sit amet, consectetur maksu rez do eiusmod tempor magna aliqua',
        ]);

        $features = [];

        $features[0] = [
            'title' => 'Any Time Any Place',
            'text' => 'Lorem ipsum dolor sit amet to be consectetur adipiscing elit, sed do eiusmod tempor.',
            'icon' => 'icofont icofont-clock-time',
            'priority' => 1,
        ];

        $features[1] = [
            'title' => 'Experience Instructors',
            'text' => 'Lorem ipsum dolor sit amet to be consectetur adipiscing elit, sed do eiusmod tempor.',
            'icon' => 'icofont icofont-man-in-glasses',
            'priority' => 2,
        ];

        $features[2] = [
            'title' => 'Quick License',
            'text' => 'Lorem ipsum dolor sit amet to be consectetur adipiscing elit, sed do eiusmod tempor.',
            'icon' => 'icofont icofont-file-spreadsheet',
            'priority' => 3,
        ];

        $features[3] = [
            'title' => 'Unlimited Car Support',
            'text' => 'Lorem ipsum dolor sit amet to be consectetur adipiscing elit, sed do eiusmod tempor.',
            'icon' => 'icofont icofont-file-spreadsheet',
            'priority' => 4,
        ];

        $features[4] = [
            'title' => 'Learning Roads',
            'text' => 'Lorem ipsum dolor sit amet to be consectetur adipiscing elit, sed do eiusmod tempor.',
            'icon' => 'icofont icofont-file-spreadsheet',
            'priority' => 5,
        ];

        $features[5] = [
            'title' => 'Video Classes',
            'text' => 'Lorem ipsum dolor sit amet to be consectetur adipiscing elit, sed do eiusmod tempor.',
            'icon' => 'icofont icofont-file-spreadsheet',
            'priority' => 6,
        ];

        foreach ($features as $key => $feature) {
            Feature::create($feature);
        }

        // counter_facts
        $counter_facts = [];

        $counter_facts[0] = [
            'amount' => 6500,
            'text' => 'GRADUATED FROM HERE',
            'icon' => 'icofont icofont-hat-alt',
            'priority' => 1,
        ];

        $counter_facts[1] = [
            'amount' => 56,
            'text' => 'TEACHERS NUMBER',
            'icon' => 'icofont icofont-user-suited',
            'priority' => 2,
        ];

        $counter_facts[2] = [
            'amount' => 11,
            'text' => 'YEARS ON MARKET',
            'icon' => 'icofont icofont-history',
            'priority' => 3,
        ];

        $counter_facts[3] = [
            'amount' => 550,
            'text' => 'PRESENT STUDENTS',
            'icon' => 'icofont icofont-users-social',
            'priority' => 4,
        ];

        foreach ($counter_facts as $counter_fact) {
            CounterFact::create($counter_fact);
        }

        // training_process_video
        $training_process_video = [
            'title' => 'Our Training Process',
            'link' => 'https://www.youtube.com/watch?v=oSEkdLGGCSY',
        ];

        TrainingProcessVideo::create($training_process_video);

        //contact page

        //branches
        $branch_part = [
            'title' => 'Our Branches',
            'subtitle' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit laboriosam laudantium iusitationem rerum neque officiis doloremque excepturi.',
        ];

        BranchPart::create($branch_part);

        //contact us part
        $contact_part = [
            'title' => 'Get In Touch',
            'subtitle' => 'For any emergency query, Please contact our Inform.',
        ];

        ContactPart::create($contact_part);

        //about part
        $about_part = [
            'about_video_link' => 'https://www.youtube.com/embed/lPJVi797Uy0',
            'about_text' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Praesentium dignissimos quas perferendis ipsam, incidunt optio quae libero id odio, maiores explicabo deserunt, distinctio culpa? Nam magni eum ad. Cum nobis incidunt alias! Exercitationem perspiciatis autem amet repellat vero maxime omnis nam ipsa, cum suscipit modi explicabo eum accusamus adipisci minus quam sapiente eius. Distinctio possimus quos, assumenda saepe quam sunt quis recusandae alias unde sint deleniti earum cumque repudiandae dignissimos, molestiae facilis, tenetur iste blanditiis laboriosam explicabo voluptatibus similique! Veritatis minus quasi enim magnam earum perferendis. alias explicabo totam, beatae quis, cupiditate maxime! Explicabo, consequatur odio? Neque, consequuntur debitis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, sequi iure amet voluptatem aspernatur tempora repellendus eligendi assumenda eaque sint est ut totam maiores quisquam nulla doloremque eveniet exercitationem molestias voluptas tenetur? Nesciunt magnam illum beatae porro adipisci. Voluptatum doloribus corrupti quo dicta saepe ipsa magnam voluptate animi ipsum minima.',
        ];

        AboutPart::create($about_part);

        //director_speech part
        $director_speech_part = [
            'director_image' => 'director.jpg',
            'director_name' => 'Muhammad Shahin',
            'director_speech' => "I'm Md. Shahin. I have joined 'Pathway' 2014 as an Executive Director. From the very beginning of the Joining pathway, I'm trying my best to uplift the image of 'pathway' by hard work, passion, honesty, conscience, and steadiness from the last three consecutive sessions. The one & only aim of mine working with 'pathway' is to do something good & wellbeing for mankind, humanity. To eradicate poverty, unemployment & uplift the socio-economic status of the third gender is basic concentration. I know how horrible it is to live with starvation because I was belonging to a lower-middle-class family. I tried my best and gave a lot of effort, hard work to reach this position. At that time, I promised myself that, 'if I could make my life sustainable then I will definitely do something for this poor, unprivileged population'. 'Pathway' has given me the opportunity to do for humanity. So we ( I & Pathway) will try heart and soul to make the socio-economic change of unprivileged, poor population. Because we believe, 'overall development of a country depends on the development of every single soul of a country'.",
        ];

        DirectorSpeechPart::create($director_speech_part);

        //certified_by part
        $certified_by_parts = [];
        $certified_by_parts[0] = [
            'certified_by' => 'Demo 1',
            'certificate_image' => 'def-image.png',
        ];

        $certified_by_parts[1] = [
            'certified_by' => 'Demo 2',
            'certificate_image' => 'def-image.png',
        ];

        $certified_by_parts[2] = [
            'certified_by' => 'Demo 3',
            'certificate_image' => 'def-image.png',
        ];

        foreach ($certified_by_parts as $certified_by_part) {
            CertifiedByPart::create($certified_by_part);
        }

        //faq part
        $faq_questions = [];
        $faq_questions[0] = [
            'question' => 'Demo question 1?',
            'answer' => 'demo-answer',
        ];

        $faq_questions[1] = [
            'question' => 'Demo question 2?',
            'answer' => 'demo-answer',
        ];

        $faq_questions[2] = [
            'question' => 'Demo question 3?',
            'answer' => 'demo-answer',
        ];

        $faq_questions[3] = [
            'question' => 'Demo question 4?',
            'answer' => 'demo-answer',
        ];

        foreach ($faq_questions as $faq_question) {
            FaqQuestion::create($faq_question);
        }

        //faq_iamge part
        $faq_iamge = [
            'image' => 'def-image.jpg',
        ];

        FaqImage::create($faq_iamge);


        //gallery part
        $gallery_images = [];
        $gallery_images[0] = [
            'image_class' => 'vehicles',
            'image' => 'def-image-1.jpg',
        ];

        $gallery_images[1] = [
            'image_class' => 'vehicles',
            'image' => 'def-image-2.jpg',
        ];

        $gallery_images[2] = [
            'image_class' => 'vehicles',
            'image' => 'def-image-3.jpg',
        ];

        $gallery_images[3] = [
            'image_class' => 'students',
            'image' => 'def-image-4.jpg',
        ];

        $gallery_images[4] = [
            'image_class' => 'classrooms',
            'image' => 'def-image-5.jpg',
        ];

        $gallery_images[5] = [
            'image_class' => 'exams',
            'image' => 'def-image-6.jpg',
        ];

        foreach ($gallery_images as $gallery_image) {
            GalleryImage::create($gallery_image);
        }

        //Privacy Policy part
        $privacy_policy = [
            'privacy_policy' => 'Privacy Policy Not Set Yet!',
        ];

        PrivacyPolicy::create($privacy_policy);

        //terms & conditions part
        $terms_and_conditions = [
            'terms_and_conditions' => 'Terms & Conditions Not Set Yet!',
        ];

        TermsAndCondition::create($terms_and_conditions);

        //Refund Policy part
        $refund_policy = [
            'refund_policy' => 'Refund Policy Not Set Yet!',
        ];

        RefundPolicy::create($refund_policy);

        //blogs part
        $blogs = [];
        $blogs[0] = [
            'blog_title' => 'Demo Title',
            'blog_post' => 'Demo Blog Post',
            'blog_category' => 'Blog Category',
        ];

        $blogs[1] = [
            'blog_title' => 'Demo Title',
            'blog_post' => 'Demo Blog Post',
            'blog_category' => 'Blog Category',
        ];

        $blogs[2] = [
            'blog_title' => 'Demo Title',
            'blog_post' => 'Demo Blog Post',
            'blog_category' => 'Blog Category',
        ];

        $blogs[3] = [
            'blog_title' => 'Demo Title',
            'blog_post' => 'Demo Blog Post',
            'blog_category' => 'Blog Category',
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}

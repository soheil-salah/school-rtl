<?php

namespace App\Modules\Admins\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EducationalStage;
use App\Models\EducationalYear;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EducationalStagesAndYearsController extends Controller
{
    public function index()
    {
       $educationalStages = EducationalStage::get();

       return view('admin.educational-stages-and-years.index', compact('educationalStages'));
    }

    public function show($slug)
    {
       $educationalStage = EducationalStage::where('slug', $slug)->first();

       return view('admin.educational-stages-and-years.show', compact('educationalStage'));
    }

    public function educationStageForm()
    {
        return view('admin.educational-stages-and-years.educationa-stage-form');
    }

    public function create(Request $request)
    {
        $education_stage_name = $request->education_stage_name;
        $educational_years = $request->educational_years;
        
        $slug = Str::slug($education_stage_name);

        $thumbnail_name = null;

        if($request->hasFile('thumbnail')){

            $thumbnail = $request->file('thumbnail');

            $thumbnail_name = md5(uniqid()).'.'.$thumbnail->extension();

            $thumbnail_path = public_path('uploads/education-stage/'.$slug);

            $thumbnail->move($thumbnail_path, $thumbnail_name);
        }

        $educationalStage = EducationalStage::firstOrCreate(['slug' => Str::slug($education_stage_name)], [
            'name' => $education_stage_name,
            'thumbnail' => $thumbnail_name,
            'slug' => $slug,
        ]);

        for($i = 0; $i < count($educational_years); $i++){

            EducationalYear::create([
                'educational_stage_id' => $educationalStage->id,
                'name' => $educational_years[$i]['educational_year'],
                'slug' => Str::slug($educational_years[$i]['educational_year']),
            ]);
        }
    }

    public function addEducationalYear(Request $request)
    {
        $educational_years = $request->educational_years;

        for($i = 0; $i < count($educational_years); $i++){

            EducationalYear::create([
                'educational_stage_id' => $request->educational_stage_id,
                'name' => $educational_years[$i]['educational_year'],
                'slug' => Str::slug($educational_years[$i]['educational_year']),
            ]);
        }
    }

    public function updateEducationalStageContent(Request $request)
    {
        EducationalStage::where('id', $request->educational_stage_id)->update([
            'content' => $request->content
        ]);
    }

    public function updateEducationalStageThumbnail(Request $request)
    {
        $educationalStage = EducationalStage::where('id', $request->education_stage_id)->first();

        # get old thumbnail
        $old_thumbnail = public_path('uploads/education-stage/'.$educationalStage->slug.'/'.$educationalStage->thumbnail);

        # delete old thumbnail if exists
        file_exists($old_thumbnail) && !is_dir($old_thumbnail) ? unlink($old_thumbnail) : true;

        # get thumbnail new name
        $thumbnail = $request->file('educational_stage_thumbnail');
        $thumbnail_name = md5(uniqid()).'.'.$thumbnail->extension();

        # upload new thumbnail
        $thumbnail->move(public_path('uploads/education-stage/'.$educationalStage->slug), $thumbnail_name);

        # update thumbnail name in the database
        $educationalStage->update([
            'thumbnail' => $thumbnail_name,
        ]);
    }

    public function deleteEducationalStageThumbnail(Request $request)
    {
        $educationalStage = EducationalStage::where('id', $request->educational_stage_id)->first();

        # get old thumbnail
        $old_thumbnail = public_path('uploads/education-stage/'.$educationalStage->slug.'/'.$educationalStage->thumbnail);

        # delete old thumbnail if exists
        file_exists($old_thumbnail) && !is_dir($old_thumbnail) ? unlink($old_thumbnail) : true;

        # update thumbnail name in the database
        $educationalStage->update([
            'thumbnail' => null,
        ]);
    }

    public function previewEducationalYearForUpdate(Request $request)
    {
        $educationalYear = EducationalYear::where('id', $request->educational_year_id)->first();

        return view('admin.educational-stages-and-years.update-educational-year-info', compact('educationalYear'));
    }

    public function updateEducationalYearInfo(Request $request)
    {
        if(EducationalYear::where('id', $request->education_year_id)->where('order', $request->order)->first() != null){

            throw new Exception('لا يمكنك تكرار الترنيب');
        }

        EducationalYear::where('id', $request->education_year_id)->update([
            'order' => $request->order,
            'name' => $request->education_year_name,
        ]);
    }

    public function deleteEducationalYearInfo(Request $request)
    {
        EducationalYear::where('id', $request->educational_year_id)->delete();
    }

    public function publishOrUnpublish(Request $request)
    {
        $educational_year_id = $request->educational_year_id;
        $isPublished = $request->isPublished == "1" ? 0 : 1;

        EducationalYear::where('id', $request->educational_year_id)->update([
            'isPublished' => $isPublished,
        ]);
    }
}

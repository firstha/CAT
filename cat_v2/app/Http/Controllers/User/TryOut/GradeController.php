<?php

namespace App\Http\Controllers\User\TryOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Exam\GradeRepository;
use App\Charts\SectionGradeChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Services\CalculateGradeService;

class GradeController extends Controller
{
    protected $gradeRepository;

    public function __construct(GradeRepository $gradeRepository)
    {
        $this->gradeRepository = $gradeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('User/TryOut/Grade/Index', [
            'grades' => $this->gradeRepository->getAllByUserPaginatedWithParams($request)
        ]);
    }

    public function show($id)
    {
        $grade = $this->gradeRepository->find($id);

        if($grade->grade_calculate == 0) {
            (new CalculateGradeService())->calculateGradeCategory($grade->id);
        }
        
        $grade = $grade->refresh();

        $rankingExams = $this->gradeRepository->getRankingByExam($grade->exam_id, 10, 1);

        $chart = new SectionGradeChart(new LarapexChart, $grade);

        return inertia('User/TryOut/Grade/Show', [
            'grade' => $grade,
            'rankingExams' => $rankingExams,
            'answers' => empty($grade->answers) ? [] : $grade->answers,
            'chart' => $chart->build()
        ]);
    }

}

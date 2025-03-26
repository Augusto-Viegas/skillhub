<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Http\Requests\StorecourseRequest;
use App\Http\Requests\UpdatecourseRequest;
use Inertia\Inertia;
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Isso deve listar todos os cursos disponíveis para o usuário
     * na página de busca.
     */
    public function index()
    {
        $courses = CourseResource::collection(course::all());
    }

    public function MyCourses()
    {
        $user = Auth::user();
        $courses = Course::where('instructor_id', $user->id)->get();
        return Inertia::render("Courses/MyCourses",
        ["courses" => CourseResource::collection($courses)]);
    }

    /**
     * Página contendo formulário para criação de curso onde apenas
     * quem é instrutor poderá ter acesso.
     */
    public function create()
    {
        return Inertia::render("Courses/Create");
    }

    /**
     * Store a newly created resource in storage.
     * Persistir os dados do curso no banco de dados.
     */
    public function store(StorecourseRequest $request)
    {
        Course::create($request->all());
        return redirect()->route("dashboard")->with("success","");
    }

    /**
     * Display the specified resource.
     * Isso deve listar apenas cursos específicos que o usuário buscar a partir de um nome.
     */
    public function show(course $course)
    {
        return "Página do curso";
    }

    /**
     * Página contento o formulário para edição de um curso do instrutor.
     */
    public function edit(course $course)
    {
        //página para editar um determinado curso
    }

    /**
     * Update the specified resource in storage.
     * Atualizar os dados do curso no banco de dados.
     */
    public function update(UpdatecourseRequest $request, course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Deletar um curso do banco de dados, apenas o instrutor tem acesso.
     */
    public function destroy(course $course)
    {
        //
    }
}

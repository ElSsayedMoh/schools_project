<?php

namespace App\Http\Livewire\Students;

use App\Models\ClassRoom;
use Livewire\Component;
use App\Models\Genders;
use App\Models\Nationalities;
use App\Models\Parents;
use App\Models\TypeBlood;
use App\Models\Grade;
use App\Models\Sections;
use App\Models\Students;
use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClassStudents extends Component
{
    public $student_page = 1 , $catchError ;
    // protected $dates = ['birthdate'];

    // form inputs
    public $name_ar , $name_en , $email , $password , 
    $nationalitie_id ,$blood_id , $Grade_id ,$Classroom_id , $gender_id ,
    $section_id ,$parent_id ,$academic_year , $year , $month , $day , $id_student ;

    // Table variables
    public $Genders , $nationals , $bloods , $my_classes , $parents , $grades , $sections ;

    public function render()
    {
        $students = Students::all();
        return view('livewire.students.class-students' , compact('students'));
    }

    public function allTables(){
        $this->Genders  = Genders::all();
        $this->nationals = Nationalities::all();
        $this->bloods = TypeBlood::all();
        $this->grades = Grade::all();
        $this->parents = Parents::all();
    }

    public function addStudent(){
        $this->allTables();
        $this->student_page = 2 ;
    }

    public function getclasses(){
        $my_classes = $this->my_classes = ClassRoom::where(['grade_id' => $this->Grade_id])->get();
        return $my_classes;
    }

    public function change_in_classes(){
        $sections = $this->sections = Sections::where(['class_id' => $this->Classroom_id])->get();
        return $sections;
    }



    public function editStudent($id){
        $this->id_student = $id;
        $this->student_page = 3 ;
        $this->allTables();
        $student = Students::findOrFail($id);
            $this->name_ar = $student->getTranslation('name' , 'ar');
            $this->name_en = $student->getTranslation('name' , 'en');
            $this->email = $student->email;
            $this->password = $student->password;
            $this->gender_id = $student->gender_id;
            $this->nationalitie_id = $student->nationalitie_id;
            $this->blood_id = $student->blood_id;
            $this->Grade_id = $student->grade_id;
            $this->Classroom_id = $student->classroom_id;
            $this->my_classes = $this->getclasses();
            $this->section_id = $student->section_id;
            $this->sections = $this->change_in_classes();
            $this->parent_id = $student->parent_id;
            $this->section_id = $student->section_id;
            $this->academic_year = $student->academic_year;
            $date_birth = explode("-",$student->date_birth);
            $this->year = $date_birth[0];
            $this->month = ltrim($date_birth[1],'0');
            $this->day = ltrim($date_birth[2],'0');
            $this->validate([ 
                'email' => 'required|email|unique:students,email,'.$this->id_student,
            ]);
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName , [
            'email' => 'required|email|unique:students,email,'.$this->id_student,
            'name_ar' => 'required',
            'name_en' => 'required',
            'password' => 'required',
            'gender_id' => 'required',
            'nationalitie_id' => 'required',
            'blood_id' => 'required',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
            'parent_id' => 'required',
            'academic_year' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
        ]);
    }

    public function listStudent(){
        $this->student_page = 1 ;
        $this->clearForm();
    }
    
    public function AddStudentInDatabase(){
        $this->validate([ 
            'email' => 'required|unique:students',
            'name_ar' => 'required',
            'name_en' => 'required',
            'password' => 'required',
            'gender_id' => 'required',
            'nationalitie_id' => 'required',
            'blood_id' => 'required',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
            'parent_id' => 'required',
            'academic_year' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
        ]);

        // try(

            $add_student = new Students();
            $add_student->name = ['ar' => $this->name_ar , 'en' => $this->name_en];
            $add_student->email = $this->email;
            $add_student->password = Hash::make($this->password);
            $add_student->gender_id = $this->gender_id;
            $add_student->nationalitie_id = $this->nationalitie_id;
            $add_student->blood_id = $this->blood_id;
            $add_student->grade_id = $this->Grade_id;
            $add_student->classroom_id = $this->Classroom_id;
            $add_student->section_id = $this->section_id;
            $add_student->parent_id = $this->parent_id;
            $add_student->academic_year = $this->academic_year;
            $add_student->date_birth = $this->year.'-'.$this->month.'-'.$this->day;
            $add_student->save();
            toastr()->success(message: trans('trans_school.Success'));
            $this->clearForm();

        // } catch (\Exception $e) {
        //     $this->catchError = $e->getMessage();
        // }
    }
    public function clearForm(){
        $this->name_ar = '';
        $this->name_en = '';
        $this->email = '';
        $this->password = '';
        $this->gender_id = '';
        $this->nationalitie_id = '';
        $this->blood_id = '';
        $this->Grade_id = '';
        $this->Classroom_id = '';
        $this->section_id = '';
        $this->parent_id = '';
        $this->academic_year = '';
        $this->year = '';
        $this->month = '';
        $this->day = '';
        $this->my_classes = '';
        $this->sections = '';
        $this->id_student = '';
    }

    public function EditStudentInDatabase(){
        try{
            // $validatedData = $this->validate();       <= خلى بالك من الحته دى لما ترجع يا عم سيد 
            $edit_student = Students::findOrFail($this->id_student);
            
            if ($edit_student->password != $this->password){
                $edit_student->update(['password' => Hash::make($this->password)]);
            }
    
            $edit_student->update();
                $edit_student->name = ['ar' => $this->name_ar , 'en' => $this->name_en];
                $edit_student->email = $this->email;
                $edit_student->gender_id = $this->gender_id;
                $edit_student->nationalitie_id = $this->nationalitie_id;
                $edit_student->blood_id = $this->blood_id;
                $edit_student->grade_id = $this->Grade_id;
                $edit_student->classroom_id = $this->Classroom_id;
                $edit_student->section_id = $this->section_id;
                $edit_student->parent_id = $this->parent_id;
                $edit_student->academic_year = $this->academic_year;
                $edit_student->date_birth = $this->year.'-'.$this->month.'-'.$this->day;
            $edit_student->save();
    
            $this->student_page = 1 ;
            toastr()->success(message: trans('trans_school.Success'));
            $this->clearForm();
        }catch (\Exception $e) {
                // $this->catchError = $e->getMessage();
            };

    }

    public function delete($id){
        $delete_student = Students::findOrFail($id);
        $delete_student->delete();
        toastr()->success(message: trans('trans_school.Success'));
    }

}

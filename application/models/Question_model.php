<?php

class Question_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('question');
        $question = $query->row();

        $question->question_type = $this->getType($question->question_type_id);
        $question->answer_options = $this->getAnswerOptions($question->id);

        return $question;
    }

    function getAll() {
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('question');
        $questions = $query->result();

        foreach ($questions as $question) {
            $question->question_type = $this->getType($question->question_type_id);
        }

        return $questions;
    }

    function getAllActive($searchString, $ids) {
        $this->db->where('active', TRUE);
        $this->db->like('text', $searchString);
        $this->db->where_not_in('id', $ids);
        $this->db->order_by('text', 'asc');
        $query = $this->db->get('question');
        $questions = $query->result();

        foreach ($questions as $question) {
            $question->question_type = $this->getType($question->question_type_id);
        }

        return $questions;
    }

    function getByIdArray($ids) {
        $this->db->where_in('id', $ids);
        $query = $this->db->get('question');
        $questions = $query->result();

        foreach ($questions as $question) {
            $question->question_type = $this->getType($question->question_type_id);
        }

        return $questions;
    }

    function insert($question) {
        $this->db->insert('question', $question);
        return $this->db->insert_id();
    }

    function getType($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('question_type');
        return $query->row();
    }

    function getAnswerOptions($question_id) {
        $this->db->where('question_id', $question_id);
        $query = $this->db->get('question_answer_option');
        $question_answer_options = $query->result();

        $answer_options = array();

        foreach ($question_answer_options as $question_answer_option) {
            $this->db->where('id', $question_answer_option->answer_option_id);
            $query = $this->db->get('answer_option');
            $answer_option = $query->row();
            array_push($answer_options, $answer_option->answer);
        }

        return $answer_options;
    }

    function getAllQuestionTypes() {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('question_type');
        return $query->result();
    }

    function insertAnswerOption($answer_options, $question_id) {
        foreach ($answer_options as $answer_option_text) {
            $question_answer_option = new stdClass();
            $question_answer_option->question_id = $question_id;

            $answer_option = new stdClass();
            $answer_option->answer = $answer_option_text;

            // Does this answer_option already exist?
            $answer_option_id = $this->existsAnswerOption($answer_option_text);

            if ($answer_option_id != 0) {
                // yes --> save association with this id
                $question_answer_option->answer_option_id = $answer_option_id;
            } else {
                // no --> insert + save association with new id
                $this->db->insert('answer_option', $answer_option);
                $question_answer_option->answer_option_id = $this->db->insert_id();
            }

            $this->db->insert('question_answer_option', $question_answer_option);
        }
    }

    function existsAnswerOption($answer) {
        $this->db->where('LOWER(answer)', strtolower(trim($answer)));
        $query = $this->db->get('answer_option');
        $answer_option = $query->row();
        if ($query->num_rows() >= 1) {
            return $answer_option->id;
        } else {
            return 0;
        }
    }

    function getSurveyQuestionCount($survey_id) {
        $this->db->where('survey_id', $survey_id);
        $query = $this->db->get('survey_question');
        return $query->num_rows();
    }

    function isQuestionUsedInSurvey($id) {
        $this->db->where('question_id', $id);
        $query = $this->db->get('survey_question');
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete($id) {
        $this->db->where('question_id', $id);
        $this->db->delete('question_answer_option');

        $this->db->where('id', $id);
        $this->db->delete('question');
    }

    function getSurveyQuestions($survey_id, $student_id) {
        $this->db->where('survey_id', $survey_id);
        $query = $this->db->get('survey_question');
        $survey_questions = $query->result();

        $questions = array();

        foreach ($survey_questions as $survey_question) {
            $question = $this->get($survey_question->question_id);
            array_push($questions, $question);
        }

        foreach ($questions as $question) {
            $question->question_type = $this->getType($question->question_type_id);
            $question->answer_or_comment = "";
            if ($this->studentHasAnswered($question->id, $student_id)) {
                $student_answer = $this->getQuestionAnswerOrComment($question->id, $student_id);
                $question->answer_or_comment = $student_answer->text_or_comment;
                $question->date_answer = $student_answer->date_answer;
                $question->answer_options = $this->getQuestionAnswerOptionsWithAnswers($question->id, $student_answer->student_answer_id);
            } else {
                $question->answer_or_comment = "";
                $question->date_answer = null;
                $question->answer_options = $this->getQuestionAnswerOptions($question->id);
            }
            
        }

        return $questions;
    }

    function getQuestionAnswerOrComment($question_id, $student_id) {
        $this->db->where('question_id', $question_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('student_answer');
        return $query->row();
    }

    function studentHasAnswered($question_id, $student_id) {
        $this->db->where('question_id', $question_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('student_answer');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getQuestionAnswerOptions($question_id) {
        $this->db->where('question_id', $question_id);
        $query = $this->db->get('question_answer_option');
        $question_answer_options = $query->result();

        $answer_options = array();

        foreach ($question_answer_options as $question_answer_option) {
            $this->db->where('id', $question_answer_option->answer_option_id);
            $query = $this->db->get('answer_option');

            $answer_option = $query->row();
            $answer_option->chosen = false;
            
            array_push($answer_options, $answer_option);
        }

        return $answer_options;
    }
    
    function getQuestionAnswerOptionsWithAnswers($question_id, $student_answer_id) {
        $this->db->where('question_id', $question_id);
        $query = $this->db->get('question_answer_option');
        $question_answer_options = $query->result();

        $answer_options = array();

        foreach ($question_answer_options as $question_answer_option) {
            $this->db->where('id', $question_answer_option->answer_option_id);
            $query = $this->db->get('answer_option');

            $answer_option = $query->row();
            $answer_option->chosen = $this->isAnswerOptionChosen($answer_option->id, $student_answer_id);
            
            array_push($answer_options, $answer_option);
        }

        return $answer_options;
    }

    function isAnswerOptionChosen($answer_option_id, $student_answer_id) {
        $this->db->where('answer_option_id', $answer_option_id);
        $this->db->where('student_answer_id', $student_answer_id);
        $query = $this->db->get('student_answer_option');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getQuestionsBySurvey($survey_id) {
        $this->db->where('survey_id', $survey_id);
        $query = $this->db->get('survey_question');
        $survey_questions = $query->result();

        $questions = array();

        foreach ($survey_questions as $survey_question) {
            $question = $this->get($survey_question->question_id);
            array_push($questions, $question);
        }

        return $questions;
    }

    function toggleActive($question) {
        $this->db->where('id', $question->id);
        $this->db->update('question', $question);
    }

    function insertSurveyQuestions($question_ids, $survey_id) {
        foreach ($question_ids as $question_id) {
            $survey_question = new stdClass();
            $survey_question->question_id = $question_id;
            $survey_question->survey_id = $survey_id;
            $this->db->insert('survey_question', $survey_question);
        }
    }

    function insertQuestionAnswers($question, $student_id) {
        $student_answer = new stdClass();
        $student_answer->question_id = $question->id;
        $student_answer->student_id = $student_id;
        $student_answer->text_or_comment = $question->answer_or_comment;
        if ($question->date_answer != null) {
            $student_answer->date_answer = $question->date_answer;
        }
        
        echo json_encode($question, JSON_PRETTY_PRINT);
        
        if ($this->studentHasAnswered($question->id, $student_id)) {
            // student has already answered this question, so update
            $student_answer_id = $this->updateStudentAnswer($student_answer);
        } else {
            // student hasn't answered this question yet, so insert
            $student_answer_id = $this->insertStudentAnswer($student_answer);
        }
        
        
        // get answers
        $current_answers = $question->chosen_answers;
        $previous_answers = $this->getChosenAnswers($question->id, $student_id);
        
        // current answers = previous answers -> do nothing
        
        // current answers, but not previous answers -> insert
        $insertAnswers = array_diff($current_answers, $previous_answers);
        foreach ($insertAnswers as $insertAnswer) {
            $student_answer_option = new stdClass();
            $student_answer_option->answer_option_id = $insertAnswer;
            $student_answer_option->student_answer_id = $student_answer_id;
            $this->db->insert('student_answer_option', $student_answer_option);
        }
        
        // not current answers, but previous answers -> delete
        $deleteAnswers = array_diff($previous_answers, $current_answers);
        foreach ($deleteAnswers as $deleteAnswer) {
            $this->db->where('answer_option_id', $deleteAnswer);
            $this->db->where('student_answer_id', $student_answer_id);
            $this->db->delete('student_answer_option');
        }
    }
    
    function getChosenAnswers($question_id, $student_id) {
        $this->db->where('question_id', $question_id);
        $this->db->where('student_id', $student_id);
        $query =  $this->db->get('student_answer');
        $student_answers = $query->result();
        
        foreach ($student_answers as $student_answer) {
            $this->db->where('student_answer_id', $student_answer->student_answer_id);
            $query = $this->db->get('student_answer_option');
            $student_answer_options = $query->result();
            $result = array();
            foreach ($student_answer_options as $option) {
                array_push($result, (int)$option->answer_option_id);
            }
            
            return $result;
        }
    }
    
    function insertStudentAnswer($student_answer) {
        $this->db->insert('student_answer', $student_answer);
        return $this->db->insert_id();
    }
    
    function updateStudentAnswer($student_answer) {
        $this->db->where('question_id', $student_answer->question_id);
        $this->db->where('student_id', $student_answer->student_id);
        $this->db->update('student_answer', $student_answer);
        
        $this->db->where('question_id', $student_answer->question_id);
        $this->db->where('student_id', $student_answer->student_id);
        return $this->db->get('student_answer')->row()->student_answer_id;
    }
}

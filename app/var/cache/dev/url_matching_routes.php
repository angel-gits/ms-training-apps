<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/trgp-control/bids/incoming' => [[['_route' => 'incoming_bids', '_controller' => 'App\\Controller\\BidController::getIncomingBids'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/bids/outgoing' => [[['_route' => 'outgoing_bids', '_controller' => 'App\\Controller\\BidController::getOutgoingBids'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/bids' => [[['_route' => 'bids', '_controller' => 'App\\Controller\\BidController::getBids'], null, ['GET' => 0], null, true, false, null]],
        '/api/trgp-control/exercises' => [[['_route' => 'app_exercise_postexercise', '_controller' => 'App\\Controller\\ExerciseController::postExercise'], null, ['POST' => 0], null, false, false, null]],
        '/api/trgp-control/exercise-plans' => [[['_route' => 'app_exerciseplan_addexercisetotrainingplan', '_controller' => 'App\\Controller\\ExercisePlanController::addExerciseToTrainingPlan'], null, ['POST' => 0], null, false, false, null]],
        '/api/trgp-control/find/program-plans' => [[['_route' => 'app_find_findplans', '_controller' => 'App\\Controller\\FindController::findPlans'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/find/training-plans' => [[['_route' => 'app_find_findtrainingplans', '_controller' => 'App\\Controller\\FindController::findTrainingPlans'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/find/exercise-names' => [[['_route' => 'app_find_getexercisenames', '_controller' => 'App\\Controller\\FindController::getExerciseNames'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/find/goals' => [[['_route' => 'app_find_getgoals', '_controller' => 'App\\Controller\\FindController::getGoals'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/find/programs' => [[['_route' => 'app_find_getprograms', '_controller' => 'App\\Controller\\FindController::getPrograms'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/find/trainings' => [[['_route' => 'app_find_gettrainings', '_controller' => 'App\\Controller\\FindController::getTrainings'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/goals' => [[['_route' => 'goal_cintrollergoals', '_controller' => 'App\\Controller\\GoalController::getGoals'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/programs' => [
            [['_route' => 'programs', '_controller' => 'App\\Controller\\ProgramController::getAllPrograms'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_program_postprogram', '_controller' => 'App\\Controller\\ProgramController::postProgram'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/trgp-control/programs/plans' => [[['_route' => 'program_plans', '_controller' => 'App\\Controller\\ProgramController::getProgramPlans'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/program-plans' => [[['_route' => 'app_programplan_postnewplan', '_controller' => 'App\\Controller\\ProgramPlanController::postNewPlan'], null, ['POST' => 0], null, false, false, null]],
        '/api/trgp-control/trainings' => [
            [['_route' => 'app_training_gettrainings', '_controller' => 'App\\Controller\\TrainingController::getTrainings'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_training_posttraining', '_controller' => 'App\\Controller\\TrainingController::postTraining'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/trgp-control/training-plans' => [[['_route' => 'app_trainingplan_addtrainingplan', '_controller' => 'App\\Controller\\TrainingPlanController::addTrainingPlan'], null, ['POST' => 0], null, false, false, null]],
        '/api/trgp-control/users' => [
            [['_route' => 'users', '_controller' => 'App\\Controller\\UserController::getUsers'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'app_user_postbid', '_controller' => 'App\\Controller\\UserController::postBid'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/trgp-control/my-users' => [[['_route' => 'trainer-users', '_controller' => 'App\\Controller\\UserController::getUserUsers'], null, ['GET' => 0], null, false, false, null]],
        '/api/trgp-control/my-trainers' => [[['_route' => 'user-trainers', '_controller' => 'App\\Controller\\UserController::getUserTrainers'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api/trgp\\-control/(?'
                    .'|bids/([^/]++)(?'
                        .'|(*:45)'
                    .')'
                    .'|exercise(?'
                        .'|s/([^/]++)(?'
                            .'|(*:77)'
                        .')'
                        .'|\\-plans/([^/]++)(?'
                            .'|(*:104)'
                        .')'
                    .')'
                    .'|program(?'
                        .'|s/(?'
                            .'|program\\-([^/]++)(*:146)'
                            .'|([^/]++)(?'
                                .'|(*:165)'
                            .')'
                        .')'
                        .'|\\-plans/([^/]++)(?'
                            .'|(*:194)'
                        .')'
                    .')'
                    .'|statistics/exercise\\-([^/]++)(*:233)'
                    .'|training(?'
                        .'|s/([^/]++)(?'
                            .'|(*:265)'
                        .')'
                        .'|\\-plans/([^/]++)(?'
                            .'|(*:293)'
                        .')'
                    .')'
                    .'|my\\-(?'
                        .'|users/([^/]++)(*:324)'
                        .'|trainers/([^/]++)(*:349)'
                    .')'
                .')'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:387)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        45 => [
            [['_route' => 'app_bid_getbid', '_controller' => 'App\\Controller\\BidController::getBid'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_bid_changebidstatus', '_controller' => 'App\\Controller\\BidController::changeBidStatus'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'app_bid_deletebid', '_controller' => 'App\\Controller\\BidController::deleteBid'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        77 => [
            [['_route' => 'exercise', '_controller' => 'App\\Controller\\ExerciseController::patchExercise'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'app_exercise_deleteexercise', '_controller' => 'App\\Controller\\ExerciseController::deleteExercise'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        104 => [
            [['_route' => 'app_exerciseplan_patchexerciseplan', '_controller' => 'App\\Controller\\ExercisePlanController::patchExercisePlan'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'app_exerciseplan_deleteexerciseplan', '_controller' => 'App\\Controller\\ExercisePlanController::deleteExercisePlan'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        146 => [[['_route' => 'program', '_controller' => 'App\\Controller\\ProgramController::getProgram'], ['id'], ['GET' => 0], null, false, true, null]],
        165 => [
            [['_route' => 'app_program_updateprogram', '_controller' => 'App\\Controller\\ProgramController::updateProgram'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'app_program_deleteprogram', '_controller' => 'App\\Controller\\ProgramController::deleteProgram'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        194 => [
            [['_route' => 'app_programplan_getcreatedprogramplan', '_controller' => 'App\\Controller\\ProgramPlanController::getCreatedProgramPlan'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_programplan_removeplan', '_controller' => 'App\\Controller\\ProgramPlanController::removePlan'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'app_programplan_editplan', '_controller' => 'App\\Controller\\ProgramPlanController::editPlan'], ['id'], ['PATCH' => 0], null, false, true, null],
        ],
        233 => [[['_route' => 'app_statistics_getforexercise', '_controller' => 'App\\Controller\\StatisticsController::getForExercise'], ['id'], ['GET' => 0], null, false, true, null]],
        265 => [
            [['_route' => 'app_training_gettraining', '_controller' => 'App\\Controller\\TrainingController::getTraining'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_training_updatetraining', '_controller' => 'App\\Controller\\TrainingController::updateTraining'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'app_training_deletetraining', '_controller' => 'App\\Controller\\TrainingController::deleteTraining'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        293 => [
            [['_route' => 'training', '_controller' => 'App\\Controller\\TrainingPlanController::getTraining'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_trainingplan_patchtraining', '_controller' => 'App\\Controller\\TrainingPlanController::patchTraining'], ['id'], ['PATCH' => 0], null, false, true, null],
            [['_route' => 'app_trainingplan_deletetraining', '_controller' => 'App\\Controller\\TrainingPlanController::deleteTraining'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        324 => [[['_route' => 'app_user_deleteuser', '_controller' => 'App\\Controller\\UserController::deleteUser'], ['id'], ['DELETE' => 0], null, false, true, null]],
        349 => [[['_route' => 'app_user_deletetrainer', '_controller' => 'App\\Controller\\UserController::deleteTrainer'], ['id'], ['DELETE' => 0], null, false, true, null]],
        387 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

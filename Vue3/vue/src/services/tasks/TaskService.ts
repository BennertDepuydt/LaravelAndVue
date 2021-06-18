// @ts-ignore
import axios from 'axios';
import API from "@/globals";
import {Category, emptyCategory} from "@/services/categories/CategoryService";
import {emptyfeedback} from "@/services/feedbacks/FeedbackService";

class TaskService {

    /*
    *
    * STUDENT TASKS
    *
    * */
    /*getStudentDashboardTasks(id: string, date: string): Promise<Array<Task>> {
        return axios.get(API + `/tasks`, {
            params: {
                studentId: id,
                date: date.substring(0, 11) + '00:00:00',
                stages: '0,2'
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.log(e);
            });
    }*/

    getStudentAllTasks(id: string, date: string): Promise<Array<Task>> {
        return axios.get(API + `/tasks`, {
            params: {
                studentId: id,
                date: date.substring(0, 11) + '00:00:00',
                stages: '0,1,2,3,4,5'
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    /*
    *
    * Mentor Student Tasks
    *
    * */
    getStudentTasksForMentor(studentId: string): Promise<Array<Task>> {
        return axios.get(API + `/tasks`, {
            params: {
                studentId: studentId,
                stages: '2'
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    /*
    *
    * Lecturer Student Tasks
    *
    * */
    getStudentTasksForLecturer(studentId: string): Promise<Array<Task>> {
        return axios.get(API + `/tasks`, {
            params: {
                studentId: studentId,
                stages: '3'
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    /*
    *
    *   Post Task
    *
    * */

    postTasks(evaluation: number,
              complexity: number,
              independency: number,
              preference: number,
              description: string,
              comment: string,
              startedAt: string,
              endedAt: string,
              subjectId: string,
              userid : string
    ): Promise<boolean> {
        return axios.post(API + `/tasks`, {
            userId: userid,
            evaluation: evaluation,
            complexity: complexity,
            preference : preference,
            independency: independency,
            description: description,
            comment: comment,
            startedAt: startedAt.substring(0, 19),
            endedAt: endedAt.substring(0, 19),
            subjectId: subjectId,
            stage: 0
        })
            .then(function (r: any) {
                console.log(r.data)
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    TaskDelete(id: string | undefined): Promise<boolean> {
        return axios.delete(API + `/tasks/`+id, {

        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    setStage(task : TaskStudent, stage: number) :  Promise<boolean> {
        task.stage = stage
        return axios.put(API + `/tasks/${task.id}`, task)
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    TaskEdit(id: string | undefined , task : TaskStudent): Promise<boolean> {
        return axios.put(API + `/tasks/`+id, task)
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

}

export interface Task {
    id: string
    title: string,
    stage: number,
}

export function emptyTask(): Task {
    return {
        id: '',
        title: '',
        stage: 0
    }
}
export interface TaskStudent {
    id: string,
    userId: string,
    comment: string,
    description: string,
    evaluation: number,
    preference : number,
    complexity: number,
    independency: number,
    subjectId: string,
    endedAt : string;
    startedAt : string
    subject: Category,
    stage : number
}


export function emptytaskstudent(): TaskStudent {
    return {
        id: '',
        userId: '',
        comment: '',
        description: '',
        evaluation: 0,
        preference : 0,
        complexity: 0,
        independency: 0,
        subjectId : '',
        endedAt : '',
        startedAt : '',
        subject: emptyCategory(),
        stage : 0
    }
}

export const taskService = new TaskService();
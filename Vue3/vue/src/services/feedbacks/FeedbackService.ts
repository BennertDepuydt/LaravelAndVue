import axios from 'axios';
import API from "@/globals";
import Vue from "vue";
import {TaskStudent} from "@/services/tasks/TaskService";
import {emptyUserProfileInfo, UserProfileInfo} from "@/services/users/UserService";
import {integer} from "vuelidate/lib/validators";


class FeedbackService {
    setmentorfeedback(mentorRemark: string, feedforward : string, mentorDifficulty: number, mentorComplexity: number, mentorIndepedence: number, mentorPositive: boolean, userId: string | undefined, taskId: string | undefined): Promise<boolean> {
        return axios.post(API + `/feedbacks`, {
            evaluation: mentorDifficulty,
            complexity: mentorComplexity,
            independency: mentorIndepedence,
            feedback: mentorRemark,
            feedforward: feedforward,
            positive: mentorPositive,
            userId: userId,
            taskId: taskId,
            createdAt : new Date().toISOString().substring(0, 19),
        })
            .then(() => true)
            .catch()

    }

    getfeedbackstudent(id: string | undefined ): Promise<TaskStudent> {
        return axios.get(API + `/tasks/`+id,  {
            params: {
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }
    setdocentfeedback(docentRemark: string, feedforward : string, docentPositive: boolean,  userid: string, taskId: string | undefined): Promise<boolean> {
        return axios.post(API + `/feedbacks`, {
            feedback: docentRemark,
            feedforward : feedforward,
            positive: docentPositive ,
            userId: userid,
            taskId: taskId,
            createdAt : new Date().toISOString()
        })
            .then(() => true)
            .catch()

    }

    getfeedbacks(id: string |undefined ) : Promise<Array<Feedback>> {
        return axios.get(API + `/tasks/`+id,  {
            params : {

            }
        })
            .then(function (r: any) {
                return r.data.feedbacks
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }
}

export interface Feedback{
    feedback: string,
    feedforward : string,
    complexity : number,
    createdAt : string,
    evaluation : number,
    independency : number,
    userId : string,
    taskId : string,
    positive : boolean,
}

export function emptyfeedback(): Feedback {
    return {
        feedback: "",
        feedforward : "",
        complexity : 0,
        createdAt : "",
        evaluation : 0,
        independency : 0,
        userId : "",
        taskId : "",
        positive : false,
    }
}

export const feedbackService = new FeedbackService();












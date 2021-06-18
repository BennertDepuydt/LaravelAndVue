import axios from 'axios'
import API from "@/globals";

class StatisticsService {
    getProgress(studentId: string, date: string): Promise<Progress[]> {
        return axios.get(API + `/stats/progress`, {
            params: {
                studentId: studentId,
                date: date.substring(0, 11) + '00:00:00'
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    getSubject(studentId: string, date: string): Promise<Subject[]> {
        return axios.get(API + `/stats/subjects`, {
            params: {
                studentId: studentId,
                date: date.substring(0, 11) + '00:00:00'
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    getEvaluationByStudent(studentId: string): Promise<Evaluation[]> {
        return axios.get(API + `/stats/evaluation/student`, {
            params: {
                studentId: studentId,
            }
        })
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }
}

export interface Progress {
    stage: string,
    amount: string
}

export interface Subject {
    subject: string,
    amount: string
}

export interface Evaluation {
    date: string,
    evaluation: string,
    complexity: string,
    independency: string,
}


export const statisticsService = new StatisticsService()
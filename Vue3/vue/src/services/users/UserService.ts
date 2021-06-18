// @ts-ignore
import axios from 'axios';
import API from "@/globals";

class UserService {
    getUserInfo(id: string): Promise<UserProfileInfo> {

        return axios.get(API + `/users/`+id, {
        })
            .then(function (r: any) {
                return r.data

            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    getMentorStudents(mentorId: string): Promise<NameWithId[]> {
        return axios.get(API + `/mentors/students`, {
            params: {
                mentorId: mentorId
            }
        })
            .then(function (data: any) {
                const students = data.data.map((s: any) => {
                    const student: NameWithId = {
                        id: s.id,
                        username: s.username
                    }
                    return student;
                })
                return Promise.resolve(students);
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

    getLecturerStudents(lecturerId: string): Promise<NameWithId[]> {
        return axios.get(API + `/lecturers/students`, {
            params: {
                lecturerId: lecturerId
            }
        })
            .then(function (data: any) {
                const students = data.data.map((s: any) => {
                    const student: NameWithId = {
                        id: s.id,
                        username: s.username
                    }
                    return student;
                })
                return Promise.resolve(students);
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }
    getStudentDocent(studentId: string) : Promise<UserProfileInfo> {
        return axios.get(API + `/students/lecturers`, {
            params: {
                studentId: studentId
            } })
                .then(function (r: any) {
                    return r.data[0]
                })
                .catch(function (e: any) {
                    console.error('Something went wrong');
                });
        }

    getStudentMentor(studentId: string) : Promise<UserProfileInfo> {
        return axios.get(API + `/students/mentors`, {
            params: {
                studentId: studentId
            } })
            .then(function (r: any) {
                return r.data[0]
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            });
    }

}

export interface NameWithId {
    id: string,
    username: string,
}


export interface UserProfileInfo {
    id:string,
    firstname: string,
    username: string,
    email: string,
    phoneNumber: string,
    location: string,
    workplace: string,
    roles : Role,
    lastname: string,
}

export function emptyUserProfileInfo(): UserProfileInfo {
    return {
        id :'',
        firstname: '',
        lastname:'',
        roles :  emptyRole(),
        workplace : '',
        username: '',
        email: '',
        phoneNumber: '',
        location: '',
    }
}
export interface Role{
    role: string,
}

export function emptyRole() : Role{
    return {
        role: "",
    }
}

export const userService = new UserService();



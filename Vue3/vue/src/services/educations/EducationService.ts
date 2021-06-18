import axios from 'axios';
import API from "@/globals";

class EducationService {
    getEducations(): Promise<Array<string>> {
        return axios.get(API + `/edus`)
            .then(function (r: any) {
                return r.data
            })
            .catch(function (e: any) {
                console.log(e);
            });
    }
}

export const educationService = new EducationService();
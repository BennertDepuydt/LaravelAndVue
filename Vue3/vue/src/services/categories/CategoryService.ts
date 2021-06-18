import axios from 'axios'
import API from "@/globals";

class CategoryService {
    getCategoryList(id: string | undefined): Promise<Array<Category>> {

        return axios.get(API + `/edus/`+id,)
            .then(function (r: any) {
                return r.data.subjects
            })
            .catch(function (e: any) {
                console.error('Something went wrong');
            })
    }
}

export interface Category {
    id: string,
    name: string
}
export function emptyCategory(): Category {
    return {
        id: "",
        name: ""
    }
}

export const categoryService = new CategoryService()
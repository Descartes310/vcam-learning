import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import * as Routes from '../Routes'; 

@Injectable({
  providedIn: 'root',
})
export class AuthService {

  constructor(private http: HttpClient) { }

  login(email: string, password: string): Promise<any> {
        let datas = {
            'email': email,
            'password': password
        }
        return this.http.post<any>(Routes.LOGIN, datas).toPromise();
    }

    /**
     * Cette fonction va sauvegarder le token du user
     * @param token // token
     */
    saveToken(token: any) {
        localStorage.setItem('token', JSON.stringify(token));
    }

    getToken(){
       return  JSON.parse(localStorage.getItem('token'));
    }

    saveUser(user: any) {
        localStorage.setItem('user', JSON.stringify(user));
    }

    getUser(){
       return  JSON.parse(localStorage.getItem('user'));
    }

}
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import * as Routes from '../Routes'; 
import { Router } from '@angular/router';
import { User } from '../_models/user.models';

@Injectable({
  providedIn: 'root',
})
export class AuthService {

  constructor(
      private http: HttpClient,
      private router: Router
    ) { }

  login(email: string, password: string): Promise<any> {
        let datas = {
            'email': email,
            'password': password
        }
        return this.http.post<any>(Routes.LOGIN, datas).toPromise();
    }

    isAuthenticated(){
        let token = this.getToken();
        let user = this.getUser();
        let now = new Date();
        let expires_at = new Date(token.expires_at);
        return token && user && (now.getTime() < expires_at.getTime());
    }

    logout() {
        if (this.isAuthenticated()) {
            this.http.delete(Routes.LOGOUT, { params: { id: '' + this.getUser().id } }).subscribe(() => { });
          }
          
          localStorage.clear();
          // Redirection apres deconnexion
          this.router.navigate(['login']);
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

    getUser(): User{
       return  new User(JSON.parse(localStorage.getItem('user')));
    }

}
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
        let user = this.getUser();
        let token = this.getToken();
        let now = (new Date()).getTime();
        if(user && token) {
            let expires_at = (new Date(token.expires_at)).getTime();
            return now < expires_at;
        } else {
            return false;
        }
    }

    logout() {
        if (this.isAuthenticated()) {
            this.http.delete(Routes.LOGOUT).subscribe(() => { });
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

    hasPermission(roles: string[]): boolean {
        let authorized = false;
        if(roles.length > 0) {
            this.getRoles().filter(role => {
              if(roles.includes(role.name))
                authorized = true;
            })
            if(authorized) {
              return true;
            } else {
              return false;
            }
        } else{
            return false;
        }
    }

    getRoles(): any {
        let user = this.getUser();
        return user ? user.roles : null
    }

    isLogged(): boolean{
        let user = this.getUser();
        let token = this.getToken();
        let now = (new Date()).getTime();
        if(user && token) {
            let expires_at = (new Date(token.expires_at)).getTime();
            return now < expires_at;
        } else {
            return false;
        }
    }

}
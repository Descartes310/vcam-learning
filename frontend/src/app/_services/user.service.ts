import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import * as Routes from '../Routes'; 
import { User } from '../_models/user.models';

@Injectable({
  providedIn: 'root',
})
export class UserService {

  constructor(private http: HttpClient) { }

  findAll(): Promise<User[]>{
      return this.http.get<User[]>(Routes.USERS).toPromise()
  }
}
import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { AuthService } from '../_services/auth.service';
import { Router } from '@angular/router';
import { User } from '../_models/user.models';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  loginForm;
  isProcessing: boolean = false;
  hasError: boolean = false;
  isSuccess: boolean = false;
  message: string = '';

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router
  ) { 
    this.loginForm = this.formBuilder.group({
      email: '',
      password: ''
    });
  }

  ngOnInit() {
    
  }

  closeAlert(){
    this.hasError = false;
    this.isSuccess = false;
    this.message = '';
  }

  onSubmit(loginData) {
    // Process checkout data here
    this.isProcessing = true;
    if(
        loginData.email.trim().length == 0 || 
        loginData.password.trim().length == 0
    ){
      this.hasError = true;
      this.isProcessing = false;
      this.message = "Veuillez bien remplir le formulaire";
      return;
    }

    this.authService.login(loginData.email, loginData.password)
    .then(response => {
      this.isSuccess = true;
      this.message = "Connexion reussie";
      this.authService.saveUser(new User(response.user));
      this.authService.saveToken({
        'access_token': response.access_token,
        'expires_at': response.expires_at,
        'token_type': response.token_type
      })
      this.router.navigate(['home']);
    })
    .catch(error => {
      console.log(error);
      this.hasError = true;
      this.message = "Email ou mot de passe incorret";
    })
    .finally(() => {
      this.isProcessing = false;
    });
  }
}

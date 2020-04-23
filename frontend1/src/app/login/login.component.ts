import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';

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
      this.message = "Veuillez bien remplir le formulaire"
      console.error('Formulaire mal rempli')
      return;
    }

    console.log('Your login data is: ', loginData);
  }
}

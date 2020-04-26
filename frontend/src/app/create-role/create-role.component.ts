import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { RoleService } from '../_services/role.service';
import { Router } from '@angular/router';
import { AuthService } from '../_services/auth.service';

@Component({
  selector: 'app-create-role',
  templateUrl: './create-role.component.html',
  styleUrls: ['./create-role.component.scss']
})
export class CreateRoleComponent implements OnInit {
  roleForm;
  isProcessing: boolean = false;
  hasError: boolean = false;
  isSuccess: boolean = false;
  message: string = '';

  constructor(
    private formBuilder: FormBuilder,
    private roleService: RoleService,
    private authService: AuthService,
    private router: Router
  ) { 
    this.roleForm = this.formBuilder.group({
      name: '',
      description: ''
    });
  }

  ngOnInit() {
    
  }

  closeAlert(){
    this.hasError = false;
    this.isSuccess = false;
    this.message = '';
  }

  onSubmit(roleData) {
    // Process checkout data here
    this.isProcessing = true;
    if(
        roleData.name.trim().length == 0 
    ){
      this.hasError = true;
      this.isProcessing = false;
      this.message = "Veuillez bien remplir le formulaire"
      console.error('Formulaire mal rempli')
      return;
    }

    this.roleService.add(roleData.name, this.authService.getUser().id)
    .then(response => {
      console.log(response);
      this.isSuccess = true;
      this.hasError = false;
      this.message = "Creation reussie";
      this.roleForm.reset();
      this.router.navigateByUrl('roles');
    })
    .catch(error => {
      console.log(error);
      this.hasError = true;
      this.isSuccess = false;
      this.message = error.error.message;
    })
    .finally(() => {
      this.isProcessing = false;
    });
  }
}

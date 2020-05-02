import { Component, OnInit } from '@angular/core';
import { RoleService } from '../_services/role.service';
import { AuthService } from '../_services/auth.service';

@Component({
  selector: 'app-roles',
  templateUrl: './roles.component.html',
  styleUrls: ['./roles.component.scss']
})
export class RolesComponent implements OnInit {

  roles: any;

  constructor(
    private roleService: RoleService,
    private authService: AuthService
  ) { }

  hasPermission(roles: string[]): boolean {
    return this.authService.hasPermission(roles);
  }

  ngOnInit() {
    this.roleService.findAll().then(
      response => {
        this.roles = response;
        console.log(response)
      }
    )
  }

}

import { NgModule } from '@angular/core';
import { Routes, RouterModule, CanActivate } from '@angular/router';
import { AuthGuardService as AuthGuard } from './_guards/auth.guard'

import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { NotfoundComponent } from './notfound/notfound.component';
import { CreateRoleComponent } from './create-role/create-role.component';
import { CreateUserComponent } from './create-user/create-user.component';
import { CreateGroupComponent } from './create-group/create-group.component';
import { UsersComponent } from './users/users.component';
import { RolesComponent } from './roles/roles.component';
import { GroupsComponent } from './groups/groups.component';
import { AuthService } from './_services/auth.service';


//const routes: Routes = [];
const routes: Routes = [
  { path: 'login', component: LoginComponent, data :{ isLoginRoute: true}, canActivate: [AuthGuard] },
  { path: 'create-role', data: {roles: ['create-role']}, component: CreateRoleComponent, canActivate: [AuthGuard] },
  { path: 'utilisateurs', component: UsersComponent, canActivate: [AuthGuard] },
  { path: 'roles', data: {roles: ['create-role', 'list-role']}, component: RolesComponent, canActivate: [AuthGuard] },
  { path: 'groups', component: GroupsComponent, canActivate: [AuthGuard] },
  { path: '', component: HomeComponent, canActivate: [AuthGuard] },
  { path: 'home', component: HomeComponent, canActivate: [AuthGuard] },
  { path: '404', component: NotfoundComponent },
  { path: '**', redirectTo: '404' },
];
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

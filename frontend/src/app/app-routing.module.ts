import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { NotfoundComponent } from './notfound/notfound.component';
import { CreateRoleComponent } from './create-role/create-role.component';
import { CreateUserComponent } from './create-user/create-user.component';
import { CreateGroupComponent } from './create-group/create-group.component';
import { UsersComponent } from './users/users.component';
import { RolesComponent } from './roles/roles.component';
import { GroupsComponent } from './groups/groups.component';


//const routes: Routes = [];
const routes: Routes = [
  { path: 'login', component: LoginComponent },
  { path: 'create-role', component: CreateRoleComponent },
  { path: 'utilisateurs', component: UsersComponent },
  { path: 'roles', component: RolesComponent },
  { path: 'groups', component: GroupsComponent },
  { path: '', component: HomeComponent },
  { path: 'home', component: HomeComponent },
  { path: '404', component: NotfoundComponent },
  { path: '**', redirectTo: '404' },
];
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

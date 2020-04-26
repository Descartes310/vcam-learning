import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavBarComponent } from './nav-bar/nav-bar.component';
import { FooterComponent } from './footer/footer.component';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { NotfoundComponent } from './notfound/notfound.component';
import { CreateRoleComponent } from './create-role/create-role.component';
import { UsersComponent } from './users/users.component';
import { RolesComponent } from './roles/roles.component';
import { GroupsComponent } from './groups/groups.component';
import { CreateUserComponent } from './create-user/create-user.component';
import { CreateGroupComponent } from './create-group/create-group.component';
import { UpdateUserComponent } from './update-user/update-user.component';
import { UpdateRoleComponent } from './update-role/update-role.component';
import { UpdateGroupComponent } from './update-group/update-group.component';

@NgModule({
  declarations: [
    AppComponent,
    NavBarComponent,
    FooterComponent,
    LoginComponent,
    HomeComponent,
    NotfoundComponent,
    CreateRoleComponent,
    UsersComponent,
    RolesComponent,
    GroupsComponent,
    CreateUserComponent,
    CreateGroupComponent,
    UpdateUserComponent,
    UpdateRoleComponent,
    UpdateGroupComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }

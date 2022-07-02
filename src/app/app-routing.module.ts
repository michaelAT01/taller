import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from "./components/home/home.component";
import { ClienteComponent } from "./components/cliente/cliente.component";
import { ArtefactoComponent } from "./components/artefacto/artefacto.component";
import { LoginComponent } from "./components/login/login.component";
import { AuthGuard } from "./shared/guards/auth.guard";
import { LoginGuard } from "./shared/guards/login.guard";
import { TecnicoComponent } from "./components/tecnico/tecnico.component";
import { Role } from './shared/models/role.model';
import { Error403Component } from './components/error403/error403.component';
import { ChangePasswComponent } from './components/change-passw/change-passw.component';


const routes: Routes = [

  {
    path: 'home', component: HomeComponent
  },
  {
    path: 'cliente', component: ClienteComponent, canActivate: [AuthGuard],
    data: { roles: [Role.Admin, Role.Oficinista] }
  },
  {
    path: 'artefacto', component: ArtefactoComponent
  },
  {
    path: 'login', component: LoginComponent, canActivate: [LoginGuard]
  },
  {
    path: '', pathMatch: 'full', redirectTo: 'login'
  },
  {
    path: 'tecnico', component: TecnicoComponent, canActivate: [AuthGuard]
  },
  {
    path: 'error403', component: Error403Component
  },
  {
    path: 'passw', component: ChangePasswComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

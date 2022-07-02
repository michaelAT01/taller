import { Component, OnInit } from '@angular/core';
import {AuthService} from "../../shared/services/auth.service";

@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrls: ['./nav-bar.component.css']
})
export class NavBarComponent implements OnInit {

  usuario : string = 'Bryan';

  constructor(private authSrv : AuthService) { }

  onLogout(){
    this.authSrv.loggout()
  }

  ngOnInit(): void {
    this.usuario = this.authSrv.valueUrsActual.usr
    this.authSrv.usrActual.subscribe(
      data =>
        this.usuario = data.nom
    )
  }

}

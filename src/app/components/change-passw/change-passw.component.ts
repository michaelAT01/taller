import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {PasswService} from "../../shared/services/passw.service";

@Component({
  selector: 'app-change-passw',
  templateUrl: './change-passw.component.html',
  styleUrls: ['./change-passw.component.css']
})
export class ChangePasswComponent implements OnInit {

  frmPassw : FormGroup;
  errLogin : boolean = false;

  constructor(private fb : FormBuilder, private passwS : PasswService) {
    this.frmPassw = this.fb.group({
      idUsuario : ['', Validators.required],
      passw : ['', Validators.required],
      passwR : ['', Validators.required]
    })
  }

  onSubmit(){
    this.passwS.resetearPassw(this.c.value).subscribe()
  }

  get c (){
    return this.frmPassw
  }

  ngOnInit(): void {
  }

}
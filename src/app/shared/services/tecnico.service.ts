import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { catchError, Observable, retry, throwError } from 'rxjs';
import { environment } from 'src/environments/environment';
import {Tecnico} from "../models/tecnico.model";

@Injectable({
  providedIn: 'root'
})
export class TecnicoService {
  SRV : string = environment.SRV;

  constructor(
    private http :HttpClient
  ) { }
  httpOptions ={
    headers: new HttpHeaders({
      'Content-Type' : 'Application/json'
    })
  }

  filtrar(parametros: any, pag: number, lim :number) : Observable<Tecnico>{
    let params = new HttpParams;
    for (const prop in parametros){
      if(prop){
        params = params.append(prop, parametros[prop])
      }
    }
    return this.http.get<Tecnico>(`${this.SRV}/tecnico/${pag}/${lim}`, {params:params})
      .pipe(retry(1),catchError(this.handleError));
  }
  buscar(id: any) : Observable <Tecnico>{
    return this.http.get<Tecnico>(`${this.SRV}/tecnico/${id}`)
      .pipe(retry(1), catchError(this.handleError));
  }
  guardar(datos : Tecnico, id? : number) : Observable<any>{
    if(id){
      //modificar
      return this.http.put<Tecnico>(`${this.SRV}/tecnico/${id}`,datos, this.httpOptions)
        .pipe(retry(1), catchError(this.handleError));
    }else{
      //crear nuevo
      return this.http.post<Tecnico>(`${this.SRV}/tecnico/`,datos, this.httpOptions)
        .pipe(retry(1), catchError(this.handleError));
    }
  }
  eliminar(id : any){
    return this.http.delete<Tecnico>(`${this.SRV}/tecnico/${id}`)
      .pipe(retry(1), catchError(this.handleError));
  }
  private handleError(error:any){
    return  throwError(
      ()=>{
        return error.status
      })
  }
}

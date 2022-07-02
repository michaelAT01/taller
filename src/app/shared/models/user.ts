export class User {
  usr: string;
  rol: number;
  nom: string;

  constructor(user?: User) {
    this.usr = user === undefined ? '' : user?.usr;
    this.rol = user === undefined ? -1 : user?.rol;
    this.nom = user === undefined ? '' : user?.nom;
  }
}

export default function () {
  return {
    status: '',
    token: localStorage.getItem('tokenchi') || '',
    user : {},
    pedido:[]
  }
}

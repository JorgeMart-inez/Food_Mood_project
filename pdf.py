from flask import Flask, request, send_file
from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas
import io

app = Flask(__name__)

@app.route('/generar_pdf', methods=['POST'])
def generar_pdf():
    # Obtener datos del formulario
    anfitrion = request.form.get("anfitrion")
    fecha = request.form.get("fecha")
    lugar = request.form.get("lugar")
    hora = request.form.get("hora")
    duracion = request.form.get("duracion")
    invitados = request.form.get("invitados")
    tipo_evento = request.form.get("tipo_evento")
    aperitivo = request.form.get("aperitivo")
    entrada = request.form.get("entrada")
    plato_fuerte = request.form.get("plato_fuerte")
    bebida = request.form.get("bebida")
    metodo_pago = request.form.get("metodo_pago")
    
    # Crear buffer de memoria para el PDF
    buffer = io.BytesIO()
    pdf = canvas.Canvas(buffer, pagesize=letter)
    pdf.setTitle("Cotización de Evento")

    # Escribir en el PDF
    pdf.drawString(100, 750, "Cotización del Evento - FOOD & MOOD")
    pdf.line(100, 745, 500, 745)
    
    pdf.drawString(100, 720, f"A nombre de: {anfitrion}")
    pdf.drawString(100, 700, f"Fecha del evento: {fecha}")
    pdf.drawString(100, 680, f"Lugar: {lugar}")
    pdf.drawString(100, 660, f"Hora: {hora}")
    pdf.drawString(100, 640, f"Duración: {duracion} horas")
    pdf.drawString(100, 620, f"Invitados: {invitados}")
    pdf.drawString(100, 600, f"Tipo de Evento: {tipo_evento}")
    
    pdf.drawString(100, 570, "Servicios incluidos:")
    servicios = request.form.getlist("servicios[]")
    y = 550
    for servicio in servicios:
        pdf.drawString(120, y, f"- {servicio.capitalize()}")
        y -= 20

    pdf.drawString(100, y - 20, f"Aperitivo: {aperitivo}")
    pdf.drawString(100, y - 40, f"Entrada: {entrada}")
    pdf.drawString(100, y - 60, f"Plato Fuerte: {plato_fuerte}")
    pdf.drawString(100, y - 80, f"Bebida: {bebida}")
    pdf.drawString(100, y - 100, f"Método de Pago: {metodo_pago}")

    # Finalizar PDF
    pdf.save()
    buffer.seek(0)

    # Retornar PDF como respuesta
    return send_file(buffer, as_attachment=True, download_name="cotizacion_evento.pdf", mimetype="application/pdf")

if __name__ == '__main__':
    app.run(debug=True)

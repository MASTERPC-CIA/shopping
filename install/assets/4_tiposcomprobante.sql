INSERT INTO `billing_tiposcomprobante` VALUES ('01', 'Factura', 1, '01, 09', '01, 02, 03, 04, 05, 06, 07, 08, 09, 00', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('02', 'Nota o boleta de venta', 1, '01', '02, 04, 05, 07, 08, 09, 00', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('03', 'Liquidacion de compra de Bienes o PrestaciÃƒÆ’Ã‚Â³n de servicios', 1, '02, 03', '01, 02, 03, 04, 05, 06, 07, 08', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('04', 'Nota de credito', 1, '01, 02, 03, 04, 05, 06, 07, 09', '01, 02, 03, 04, 05, 06, 07, 08, 09, 00', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('05', 'Nota de debito', 1, '01, 02, 03, 04, 05, 06, 07, 09', '01, 02, 03, 04, 05, 06, 07, 08, 09, 00', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('07', 'Comprobante de Retencion', 1, '', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('08', 'Boletos o entradas a espectaculos publicos', 1, '1', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('09', 'Tiquetes o vales emitidos por maquinas registradoras', 1, '1', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('11', 'Pasajes expedidos por empresas de aviacion', 1, '1', '01, 02, 05', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('12', 'Documentos emitidos por instituciones financieras', 1, '01', '01, 02, 05', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('15', 'Comprobante de venta emitido en el Exterior', 1, '03', '02, 04, 05, 07', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('16', 'Formulario ÃƒÆ’Ã…Â¡nico de Exportacion (FUE) o DeclaraciÃƒÆ’Ã‚Â³n Aduanera ÃƒÆ’Ã…Â¡nica (DAU) o DeclaraciÃƒÆ’Ã‚Â³n Andina de Valor (DAV)', 1, '9', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('18', 'Documentos autorizados utilizados en ventas excepto N/C N/D', 1, '04, 05, 06, 07', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('19', 'Comprobantes de Pago de Cuotas o Aportes', 1, '01, 02, 03', '02, 10', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('20', 'Documentos por Servicios Administrativos emitidos por Inst. del Estado', 1, '1', '2', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('21', 'Carta de Porte aereo', 1, '1', '01, 02, 08', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('22', 'RECAP', 1, '10, 11', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('23', 'Nota de Credito TC', 1, '10, 11', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('24', 'Nota de Debito TC', 1, '10, 11', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('41', 'Comprobante de venta emitido por reembolso', 1, '01, 02, 03, 04, 05, 06, 09', '01, 02, 03, 04, 05, 06, 07', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('42', 'Documento agente de retenciÃƒÆ’Ã‚Â³n Presuntiva', 1, '1', '0', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('43', 'Liquidacion para Explotacion y Exploracion de Hidrocarburos', 1, '1', '01, 02, 06, 07', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('44', 'Comprobante de Contribuciones y Aportes', 1, '04, 05, 06', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('45', 'Liquidacion por reclamos de aseguradoras', 1, '1,03', '9', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('47', 'Nota de Credito por Reembolso Emitida por Intermediario', 1, '01, 04, 05, 06, 09', '01, 02, 03, 04, 06, 07', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('48', 'Nota de Debito por Reembolso Emitida por Intermediario', 1, '01, 04, 05, 06, 09', '01, 02, 03, 04, 06, 07', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('49', 'Proveedor Directo de Exportador Bajo RÃƒÆ’Ã‚Â©gimen Especial', 1, '4', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('50', 'A Inst. Estado y Empr. Publicas que percibe ingreso exento de Imp. Renta', 1, '4', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('51', 'N/C A Inst. Estado y Empr. Publicas que percibe ingreso exento de Imp. Renta', 1, '4', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('52', 'N/D A Inst. Estado y Empr. Publicas que percibe ingreso exento de Imp. Renta', 1, '4', '', NULL, NULL);
INSERT INTO `billing_tiposcomprobante` VALUES ('53', 'Comprobante de Ingreso', 1, NULL, NULL, NULL, NULL);


/* llenamos la tabla de Sustentos */
INSERT INTO `billing_sustento` VALUES ('00', 'Casos especiales cuyo sustento no aplica en las opciones anteriores', '1, 2, 4, 5, 42');
INSERT INTO `billing_sustento` VALUES ('01', 'Credito Tributario para declaracion de IVA (servicios y bienes distintos de inventarios y activos fijos)', '1, 3, 4, 5, 11, 12, 21, 41, 43, 47, 48');
INSERT INTO `billing_sustento` VALUES ('02', 'Costo o Gasto para declaracion de IR (servicios y bienes distintos de inventarios y activos fijos)', '1, 2, 3, 4, 5, 11, 12, 15, 19, 20, 21, 41, 43, 47, 48');
INSERT INTO `billing_sustento` VALUES ('03', 'Activo Fijo - Credito Tributario para declaraciÃƒÆ’Ã‚Â³n de IVA', '1, 3, 4, 5, 41, 47, 48');
INSERT INTO `billing_sustento` VALUES ('04', 'Activo Fijo - Costo o Gasto para declaracion de IR', '1, 2, 3, 4, 5, 15, 41, 47, 48');
INSERT INTO `billing_sustento` VALUES ('05', 'Liquidacion Gastos de Viaje, hospedaje y alimentacion Gastos IR (a nombre de empleados y no de la empresa)', '1, 2, 3, 4, 5, 11, 15, 41');
INSERT INTO `billing_sustento` VALUES ('06', 'Inventario - Credito Tributario para declaracion de IVA', '1, 3, 4, 5, 41, 43, 47, 48');
INSERT INTO `billing_sustento` VALUES ('07', 'Inventario - Costo o Gasto para declaracion de IR', '1, 2, 3, 4, 5, 15, 41, 43, 47, 48');
INSERT INTO `billing_sustento` VALUES ('08', 'Valor pagado para solicitar Reembolso de Gasto (intermediario)', '1, 2, 3, 4, 5, 21');
INSERT INTO `billing_sustento` VALUES ('09', 'Reembolso por Siniestros', '45, 4, 5');
INSERT INTO `billing_sustento` VALUES ('10', 'Distribucion de Dividendos, Beneficios o Utilidades', '19');
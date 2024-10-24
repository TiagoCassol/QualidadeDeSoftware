from selenium import webdriver
from selenium.webdriver.common.by import By
import time

driver = webdriver.Chrome()

def testar_login():
    driver.get("https://seubarriga.wcaquino.me")
    time.sleep(2)
    driver.find_element(By.ID, "email").send_keys("seu_email@teste.com")
    driver.find_element(By.ID, "senha").send_keys("sua_senha")
    driver.find_element(By.TAG_NAME, "button").click()
    time.sleep(2)
    print("Teste de Login concluído")

def testar_cadastro_conta():
    driver.find_element(By.LINK_TEXT, "Contas").click()
    driver.find_element(By.LINK_TEXT, "Adicionar").click()
    time.sleep(1)
    driver.find_element(By.ID, "nome").send_keys("Conta Teste")
    driver.find_element(By.TAG_NAME, "button").click()
    time.sleep(2)
    print("Teste de Cadastro de Conta concluído")

def testar_cadastro_transacao():
    driver.find_element(By.LINK_TEXT, "Movimentação").click()
    time.sleep(1)
    driver.find_element(By.ID, "descricao").send_keys("Teste")
    driver.find_element(By.ID, "interessado").send_keys("Teste")
    driver.find_element(By.ID, "valor").send_keys("100")
    driver.find_element(By.ID, "conta").send_keys("Conta Teste")
    driver.find_element(By.ID, "status_pago").click()
    driver.find_element(By.TAG_NAME, "button").click()
    time.sleep(2)
    print("Teste de Cadastro de Transação concluído")

def testar_consulta_saldo():
    driver.find_element(By.LINK_TEXT, "Resumo Mensal").click()
    time.sleep(2)
    print("Teste de Consulta de Saldo concluído")

def testar_exclusao_conta():
    driver.find_element(By.LINK_TEXT, "Contas").click()
    driver.find_element(By.LINK_TEXT, "Listar").click()
    time.sleep(2)
    driver.find_element(By.XPATH, "//td[contains(text(), 'Conta Teste')]/following-sibling::td/a").click()
    time.sleep(2)
    print("Teste de Exclusão de Conta concluído")

testar_login()
testar_cadastro_conta()
testar_cadastro_transacao()
testar_consulta_saldo()
testar_exclusao_conta()

driver.quit()

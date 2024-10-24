import time
import warnings

from selenium.webdriver.support.wait import WebDriverWait
import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support import expected_conditions as EC

class ExemploSeleniumWebDriver(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        warnings.filterwarnings(
            action="ignore", message="unclosed", category=ResourceWarning
        )
        self.driver.set_window_size(1920, 1080)

    def test_login(self):
        driver = self.driver
        # Abre o site
        driver.get("http://localhost/testes/kitter/")
        print("URL:", driver.current_url)
        self.assertIn("Kitter", driver.title)
        login_button = WebDriverWait(driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//a[@class='login']/button"))
        )
        login_button.click()
        time.sleep(2) 
        
        # Pagina Login
        WebDriverWait(driver, 5).until(EC.url_contains("login.php"))
        
        email_field = WebDriverWait(driver, 5).until(
            EC.visibility_of_element_located((By.NAME, "email"))
        )
        email_field.send_keys("joao.silva@email.com")
        time.sleep(1)
        
        password_field = WebDriverWait(driver, 5).until(
            EC.visibility_of_element_located((By.NAME, "password"))
        )
        password_field.send_keys("senha1")
        time.sleep(1) 
        
        sign_in_button = WebDriverWait(driver, 5).until(
            EC.element_to_be_clickable((By.ID, "submit"))
        )
        sign_in_button.click()
        time.sleep(2)  

        # Pagina de compras
        quantity_field = WebDriverWait(driver, 5).until(
            EC.visibility_of_element_located((By.NAME, "quantity"))
        )
        quantity_field.clear()  
        quantity_field.send_keys("3")  
        time.sleep(1)  

        add_to_cart_button = WebDriverWait(driver, 5).until(
            EC.element_to_be_clickable((By.NAME, "add_to_cart"))
        )
        add_to_cart_button.click()
        time.sleep(2)  
        cart_link = WebDriverWait(driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'cart.php')]"))
        )
        cart_link.click()
        time.sleep(2) 

        # PAgina Carrinho
        WebDriverWait(driver, 5).until(EC.url_contains("cart.php"))
        print("Cart page URL:", driver.current_url)
        self.assertIn("cart.php", driver.current_url)

        checkout_link = WebDriverWait(driver, 5).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'checkout.php')]"))
        )
        checkout_link.click()
        time.sleep(2)  

        # Pagina checkout
        WebDriverWait(driver, 5).until(EC.url_contains("checkout.php"))
        print("Checkout page URL:", driver.current_url)
        self.assertIn("checkout.php", driver.current_url)

    def tearDown(self):
        self.driver.close()

if __name__ == "__main__":
    unittest.main()

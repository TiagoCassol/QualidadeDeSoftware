import time
import warnings
import unittest
from selenium import webdriver
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.action_chains import ActionChains


class ExemploSeleniumWebDriver(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        warnings.filterwarnings(
            action="ignore", message="unclosed", category=ResourceWarning
        )

    def test_search_in_demoqa(self):
        driver = self.driver
        driver.get("https://demoqa.com/books")
        print("URL:", driver.current_url)

        # Ensure we are on the correct page by checking the title
        self.assertIn("DEMOQA", driver.title)

        # Find the search input and type in "Git Pocket Guide"
        search_box = driver.find_element(By.ID, "searchBox")
        search_box.send_keys("Git Pocket Guide")

        # Wait for search results to load
        time.sleep(2)

        # Check if the results contain "No rows found"
        page_source = driver.page_source
        self.assertNotIn(
            "No rows found", page_source, "Test Failed: No search results found."
        )

        print("Test Passed: Search results for 'Git Pocket Guide' found.")

    def test_click_button(self):
        # Navigate to demoqa buttons page
        driver = self.driver
        driver.get("https://demoqa.com/buttons")

        # Double-click on the double-click button
        button = driver.find_element(By.ID, "doubleClickBtn")
        action = ActionChains(driver)
        action.double_click(button).perform()

        # Give it a second to process
        time.sleep(2)

        # Validate the result (message appears)
        result = driver.find_element(By.ID, "doubleClickMessage").text
        assert (
            "You have done a double click" in result
        ), "Test Failed: Double-click message not found."

        print("Test Passed: Button Double Click")

    def test_checkbox(self):

        driver = self.driver
        # Navigate to demoqa check box page
        driver.get("https://demoqa.com/checkbox")

        # Expand the home directory
        expand_button = driver.find_element(
            By.CSS_SELECTOR, "button.rct-collapse.rct-collapse-btn"
        )
        expand_button.click()

        # Check the "Desktop" checkbox
        desktop_checkbox = driver.find_element(
            By.CSS_SELECTOR, "label[for='tree-node-desktop']"
        )
        desktop_checkbox.click()

        # Give it a second to register the click
        time.sleep(2)

        # Validate the result
        result = driver.find_element(By.ID, "result").text
        assert (
            "desktop" in result.lower()
        ), "Test Failed: Desktop checkbox not found in result."

        print("Test Passed: Checkbox Selection")

    def test_text_box_interaction(self):
        driver = self.driver

        # Navigate to demoqa text box page
        driver.get("https://demoqa.com/text-box")

        # Fill in the text box fields
        driver.find_element(By.ID, "userName").send_keys("Luciano Zanuz")
        driver.find_element(By.ID, "userEmail").send_keys("professor.zanuz@gmail.com")
        driver.find_element(By.ID, "currentAddress").send_keys("123 Fake Street")
        driver.find_element(By.ID, "permanentAddress").send_keys("456 False Avenue")

        # Scroll to the submit button to make sure it's in view
        submit_button = driver.find_element(By.ID, "submit")
        driver.execute_script("arguments[0].scrollIntoView();", submit_button)

        # Wait a moment to ensure it's scrolled
        time.sleep(1)

        # Click on the submit button
        submit_button.click()

        # Wait for the submission
        time.sleep(2)

        # Validate the output
        output_name = driver.find_element(By.ID, "name").text
        self.assertIn(
            "Luciano Zanuz", output_name, "Test Failed: Name not found in output."
        )

        print("Test Passed: Text Box Submission")

    def test_radio_button_interaction(self):
        driver = self.driver

        # Navigate to the Radio Button page
        driver.get("https://demoqa.com/radio-button")
        print("URL:", driver.current_url)

        # Ensure we are on the correct page by checking the title
        self.assertIn("DEMOQA", driver.title)

        # Use WebDriverWait to ensure the element is clickable
        yes_radio_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "label[for='yesRadio']"))
        )

        # Click the "Yes" radio button
        yes_radio_button.click()

        # Wait for the result message to appear
        time.sleep(2)

        # Verify that the success message appears
        success_message = driver.find_element(By.CLASS_NAME, "text-success").text
        self.assertEqual(
            success_message, "Yes", "Test Failed: 'Yes' radio button was not selected."
        )

        print("Test Passed: 'Yes' radio button selected successfully.")

    def tearDown(self):
        self.driver.close()


if __name__ == "__main__":
    unittest.main()
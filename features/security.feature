Feature: Security API
  In order to access a protected area
  As a user
  I need to be authenticated to before doing anything under firewall

  Scenario: Retrieve a list Partitionner
    Given the Practitioner state
    When I send a "GET" request to "/api/practitioners"
    Then the response should be in JSON
    And the JSON should be valid according to this schema:
    """
    {"": ""}
    """

def application(environ, start_response):
    # Set the response status and headers
    status = '200 OK'
    headers = [('Content-type', 'text/plain')]

    # Get the request method and path
    method = environ['REQUEST_METHOD']
    path = environ['PATH_INFO']

    # Generate the response body
    response_body = f"Hello, World! You made a {method} request to {path}."

    # Convert the response body to bytes
    response_body = response_body.encode('utf-8')

    # Call the start_response function with the status and headers
    start_response(status, headers)

    # Return the response body as an iterable
    return [response_body]
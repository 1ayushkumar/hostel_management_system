import zlib
import base64

def deflate_and_encode(plantuml_text):
    """Encode PlantUML text for URL"""
    zlibbed_str = zlib.compress(plantuml_text.encode('utf-8'))
    compressed_string = zlibbed_str[2:-4]
    return base64.b64encode(compressed_string).decode('utf-8')

# Read the PlantUML file
with open('er_diagram.puml', 'r') as f:
    content = f.read()

# Generate the URL
encoded = deflate_and_encode(content)
url = f"http://www.plantuml.com/plantuml/png/{encoded}"

print("\nYour ER diagram URL:")
print(url)

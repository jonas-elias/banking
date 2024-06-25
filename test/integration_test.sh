BASE_URL="http://localhost:9501/api"

merchant_id=$(curl -X POST "$BASE_URL/user" \
  -H "Content-Type: application/json" \
  -d '{"name": "merchant","email": "merchant@gmail.com","password": "12345678","balance": 100,"type": "merchant","document": "10101010101010"}' \
  -s | jq -r '.user')

if [ -z "$merchant_id" ]; then
  echo "Failed to create merchant user"
  exit 1
fi

echo "Merchant ID: $merchant_id"

common_id=$(curl -X POST "$BASE_URL/user" \
  -H "Content-Type: application/json" \
  -d '{"name": "common","email": "common@gmail.com","password": "12345678","balance": 100,"type": "common","document": "10101010101"}' \
  -s | jq -r '.user')

if [ -z "$common_id" ]; then
  echo "Failed to create common user"
  exit 1
fi

echo "Common ID: $common_id"

response_code=$(curl -X POST "$BASE_URL/transfer" \
  -H "Content-Type: application/json" \
  -d '{"payer": "'$common_id'", "payee": "'$merchant_id'", "value": 10}' \
  -o /dev/null -s -w "%{http_code}")

if [ "$response_code" -ne 204 ]; && [ "$response_code" -ne 403 ]; then
  echo "Failed to create transaction"
  exit 1
fi

if [ "$response_code" -ne 403 ]; then
  echo "Transaction denied by webhook"
fi

if [ "$response_code" -ne 204 ]; then
  echo "Transaction success"
fi

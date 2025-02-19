
# import sys
# import json
# import joblib

# # Load trained AI model
# model = joblib.load("ai/fake_bid_model.pkl")

# # Get bid details from Laravel
# input_data = json.loads(sys.argv[1])

# # Predict if the bid is fake (1 = Fake, 0 = Real)
# prediction = model.predict([input_data])

# print(prediction[0])  # Send result back to Laravel
import sys
import json
import joblib

# Load the trained model
model = joblib.load("C:\\Users\\LENOVO\\car-auction\\ai\\fake_bid_model.pkl")

# Load the input data passed from PHP
input_data = json.loads(sys.argv[1])

# Create DataFrame for prediction
import pandas as pd
df = pd.DataFrame([input_data], columns=["bid_amount", "time_since_last_bid", "total_bids_by_user"])

# Predict if the bid is fake (1 = Fake, 0 = Real)
prediction = model.predict(df)

# Output the prediction result (1 = Fake, 0 = Real)
print(prediction[0])

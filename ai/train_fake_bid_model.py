# import pandas as pd
# import joblib
# from sklearn.ensemble import RandomForestClassifier
# from sklearn.model_selection import train_test_split

# # Sample Data
# data = pd.DataFrame({
#     "bid_amount": [1000, 2000, 5000, 7000, 15000, 3000, 8000, 20000],
#     "time_since_last_bid": [5, 3, 10, 2, 1, 15, 2, 20],
#     "total_bids_by_user": [1, 2, 10, 3, 15, 5, 2, 20],
#     "is_fake": [0, 0, 1, 0, 1, 1, 0, 1]
# })

# X = data[["bid_amount", "time_since_last_bid", "total_bids_by_user"]]
# y = data["is_fake"]

# # Train Model
# model = RandomForestClassifier(n_estimators=100, random_state=42)
# model.fit(X, y)

# # Save Model
# joblib.dump(model, "ai/fake_bid_model.pkl")

# print("✅ AI Model Training Complete!")
import pandas as pd
import joblib
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split

# Sample training data
data = pd.DataFrame({
    "bid_amount": [1000, 2000, 5000, 7000, 15000, 3000, 8000, 20000],
    "time_since_last_bid": [5, 3, 10, 2, 1, 15, 2, 20],  
    "total_bids_by_user": [1, 2, 10, 3, 15, 5, 2, 20],  
    "is_fake": [0, 0, 1, 0, 1, 1, 0, 1]  
})

X = data[["bid_amount", "time_since_last_bid", "total_bids_by_user"]]
y = data["is_fake"]

# Train the model
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# Save the trained model
joblib.dump(model, "ai/fake_bid_model.pkl")

print("✅ Model trained successfully!")

from fastapi import FastAPI
from pydantic import BaseModel

import torch
from transformers import AutoTokenizer, AutoModelForSequenceClassification

app = FastAPI()

MODEL_PATH = "./indobert_priority_best"

tokenizer = AutoTokenizer.from_pretrained(MODEL_PATH)
model = AutoModelForSequenceClassification.from_pretrained(MODEL_PATH)

model.eval()

label_map = {
    0: "Rendah",
    1: "Sedang",
    2: "Tinggi"
}


class InputText(BaseModel):
    text: str


@app.get("/")
def home():
    return {"status": "AI API Running"}


@app.post("/predict")
def predict(data: InputText):

    inputs = tokenizer(
        data.text,
        return_tensors="pt",
        truncation=True,
        padding=True,
        max_length=256
    )

    with torch.no_grad():
        outputs = model(**inputs)

    probs = torch.softmax(outputs.logits, dim=1)

    pred_idx = torch.argmax(probs, dim=1).item()

    confidence = probs[0][pred_idx].item()

    return {
        "prediction": label_map[pred_idx],
        "confidence_score": round(confidence, 4)
    }